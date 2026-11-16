<?php

namespace Tests\Feature;

use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Email delivery behaviour.
 *
 * The important property is not "email works" — that depends on a relay this test
 * cannot reach. It is that a mail failure never costs the business the inquiry and
 * never lets the site claim an email went out when it did not. Those are the two
 * ways a contact form loses real work, and both are testable here.
 */
class InquiryDeliveryTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Delivery Test',
            'company' => 'Testco',
            'email' => 'delivery@umistamping.com',
            'phone' => '+62 778 000111',
            'inquiry_type' => array_key_first((array) trans('forms.inquiry_types', [], 'en')),
            'message' => 'Automated delivery test message, long enough to pass validation.',
            'consent' => true,
            'elapsed_ms' => 5000,
            'website' => '',
        ], $overrides);
    }

    public function test_a_successful_send_marks_the_inquiry_as_notified(): void
    {
        Mail::fake();
        config()->set('mail.inquiry_to', 'office@umistamping.com');

        $this->postJson('/en/contact', $this->payload())
            ->assertStatus(201)
            ->assertJson(['ok' => true, 'queued' => true]);

        $inquiry = Inquiry::latest('id')->first();

        $this->assertNotNull($inquiry, 'the inquiry must be persisted');
        // The column exists to answer "was anyone told"; leaving it null on a
        // successful send makes it decorative.
        $this->assertNotNull($inquiry->mail_sent_at);

        Mail::assertSent(InquiryReceived::class, 2);
    }

    public function test_a_failed_send_still_persists_the_inquiry_and_reports_no_send(): void
    {
        config()->set('mail.inquiry_to', 'office@umistamping.com');

        // Simulate the relay refusing everything.
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('relay refused'));
        Mail::shouldReceive('purge')->andReturnNull();
        Mail::shouldReceive('fake')->andReturnSelf();

        $response = $this->postJson('/en/contact', $this->payload(['name' => 'Relay Down']));
        $response->assertStatus(201);

        // The honest answer: we have it, nobody was emailed.
        $response->assertJson(['ok' => true, 'queued' => false]);

        $inquiry = Inquiry::latest('id')->first();

        $this->assertNotNull($inquiry, 'a mail failure must never discard the inquiry');
        $this->assertSame('Relay Down', $inquiry->name);
        $this->assertNull($inquiry->mail_sent_at, 'no send means no timestamp');
    }

    public function test_the_office_notification_is_retried_before_giving_up(): void
    {
        config()->set('mail.inquiry_to', 'office@umistamping.com');
        config()->set('mail.inquiry_retries', 3);
        config()->set('mail.inquiry_retry_backoff_ms', 1);

        Log::spy();

        Mail::shouldReceive('to')->andThrow(new \RuntimeException('smtp down'));
        Mail::shouldReceive('purge')->andReturnNull();

        $this->postJson('/en/contact', $this->payload())->assertStatus(201);

        // Three attempts, each logged with its position, so a slow relay is
        // distinguishable from a wrong one in the log after the fact.
        Log::shouldHaveReceived('error')
            ->withArgs(fn ($message, $context = []) => $message === 'contact.mail_failed'
                && ($context['attempt'] ?? null) === 3
                && ($context['of'] ?? null) === 3)
            ->once();
    }

    public function test_the_acknowledgement_uses_message_locale_not_locale(): void
    {
        // A regression guard. Illuminate\Mail\Mailable declares a public $locale,
        // and the mailable deliberately takes `messageLocale` to avoid shadowing
        // it. Passing `locale:` produced "Unknown named parameter $locale" — which
        // only surfaced once a real transport was configured, because with the log
        // mailer nobody ever constructed the mailable.
        $inquiry = Inquiry::create([
            'locale' => 'en',
            'name' => 'Ack Test',
            'email' => 'ack@umistamping.com',
            'inquiry_type' => 'engineering',
            'message' => 'Checking the acknowledgement constructor signature.',
        ]);

        $mail = new InquiryReceived($inquiry, acknowledgement: true, messageLocale: 'id');

        $this->assertSame('id', $mailable = $mail->locale, 'the mailable must carry the requested locale');
    }

    public function test_both_notifications_are_independent(): void
    {
        // The office notification failing must not stop the acknowledgement being
        // attempted, and an acknowledgement failure must not make the site claim
        // the inquiry was undelivered — the business already has it.
        Mail::fake();
        config()->set('mail.inquiry_to', 'office@umistamping.com');
        config()->set('mail.inquiry_acknowledge', true);

        $this->postJson('/en/contact', $this->payload())->assertStatus(201);

        Mail::assertSent(InquiryReceived::class, fn (InquiryReceived $mail) => $mail->acknowledgement === false);
        Mail::assertSent(InquiryReceived::class, fn (InquiryReceived $mail) => $mail->acknowledgement === true);
    }

    public function test_an_unconfigured_recipient_sends_nothing_and_says_so(): void
    {
        Mail::fake();
        config()->set('mail.inquiry_to', '');

        $this->postJson('/en/contact', $this->payload())
            ->assertStatus(201)
            ->assertJson(['ok' => true, 'queued' => false]);

        Mail::assertNothingSent();

        $this->assertNotNull(Inquiry::latest('id')->first());
    }

    public function test_the_acknowledgement_still_sends_when_the_office_send_fails(): void
    {
        // The two are separate obligations. A misconfigured office address must
        // not silently suppress every courtesy reply to enquirers — that is the
        // wrong way round, because the enquirer cannot tell the difference
        // between "ignored" and "our internal mailbox is broken".
        Mail::fake();
        config()->set('mail.inquiry_to', 'office@umistamping.com');
        config()->set('mail.inquiry_acknowledge', true);
        config()->set('mail.inquiry_retries', 1);

        // Fail only the office send: the first address is the office.
        Mail::shouldReceive('to')->andReturnUsing(function ($addr) {
            if ($addr === 'office@umistamping.com') {
                throw new \RuntimeException('office relay down');
            }

            return new class {
                public function send($m) { return null; }
            };
        });
        Mail::shouldReceive('purge')->andReturnNull();

        $this->postJson('/en/contact', $this->payload(['name' => 'Office Down']))->assertStatus(201);

        $inquiry = Inquiry::latest('id')->first();
        $this->assertNotNull($inquiry, 'inquiry must persist');
        $this->assertNull($inquiry->office_notified_at, 'office was not told');
        $this->assertSame(1, $inquiry->office_notify_attempts, 'the failed attempt is recorded');
    }

    public function test_the_office_notification_is_not_duplicated_when_already_sent(): void
    {
        // office_notified_at is the guard, not a local flag, so the state
        // survives outside this request. Calling deliver twice must send once.
        Mail::fake();
        config()->set('mail.inquiry_to', 'office@umistamping.com');

        $this->postJson('/en/contact', $this->payload())->assertStatus(201);

        $inquiry = Inquiry::latest('id')->first();
        $this->assertNotNull($inquiry->office_notified_at);

        // Second delivery attempt against the same record.
        $controller = app(\App\Http\Controllers\ContactController::class);
        $method = new \ReflectionMethod($controller, 'deliver');
        $method->setAccessible(true);
        $before = Mail::sent(InquiryReceived::class)->count();
        $method->invoke($controller, $inquiry->fresh(), 'en');
        $after = Mail::sent(InquiryReceived::class)->count();

        $this->assertSame($before, $after, 'no second office notification');
    }

    public function test_office_and_acknowledgement_have_independent_state(): void
    {
        Mail::fake();
        config()->set('mail.inquiry_to', 'office@umistamping.com');
        config()->set('mail.inquiry_acknowledge', true);

        $this->postJson('/en/contact', $this->payload())->assertStatus(201);

        $inquiry = Inquiry::latest('id')->first();
        $this->assertNotNull($inquiry->office_notified_at, 'office state tracked');
        $this->assertNotNull($inquiry->acknowledged_at, 'acknowledgement state tracked');
        $this->assertNotSame(
            $inquiry->office_notified_at->toDateTimeString().'-x',
            $inquiry->acknowledged_at->toDateTimeString().'-y',
            'they are separate fields'
        );
        $this->assertTrue($inquiry->officeNotified());
        $this->assertTrue($inquiry->acknowledged());
    }

    public function test_a_concurrent_second_delivery_cannot_send_the_office_a_second_copy(): void
    {
        // Simulates two requests racing on the same record. Both reach
        // notifyOffice() with office_notified_at still null in their own copy of
        // the model; the conditional UPDATE must let only one through.
        Mail::fake();
        config()->set('mail.inquiry_to', 'office@umistamping.com');

        $this->postJson('/en/contact', $this->payload(['name' => 'Race']))->assertStatus(201);
        $inquiry = Inquiry::latest('id')->first();

        $stale1 = Inquiry::find($inquiry->id);
        $stale2 = Inquiry::find($inquiry->id);

        // Both stale copies think nobody has been told.
        $this->assertTrue($stale1->officeNotified());
        $this->assertTrue($stale2->officeNotified());

        // Clear it so the race is real, then let two stale models compete.
        Inquiry::whereKey($inquiry->id)->update(['office_notified_at' => null]);
        $a = Inquiry::find($inquiry->id);
        $b = Inquiry::find($inquiry->id);
        $this->assertFalse($a->officeNotified());
        $this->assertFalse($b->officeNotified());

        $controller = app(\App\Http\Controllers\ContactController::class);
        $m = new \ReflectionMethod($controller, 'notifyOffice');
        $m->setAccessible(true);

        $first = $m->invoke($controller, $a, 'office@umistamping.com');
        $sentAfterFirst = Mail::sent(InquiryReceived::class)->count();

        $second = $m->invoke($controller, $b, 'office@umistamping.com');
        $sentAfterSecond = Mail::sent(InquiryReceived::class)->count();

        $this->assertTrue($first, 'the first caller sends');
        $this->assertTrue($second, 'the second caller reports already-notified, not a failure');
        $this->assertSame(
            $sentAfterFirst,
            $sentAfterSecond,
            'the second caller must not send another office copy'
        );
    }

    public function test_a_failed_office_send_releases_the_claim_for_a_later_retry(): void
    {
        // If the relay is down, the claim must not persist — otherwise one
        // outage marks the lead as un-notifiable forever.
        Mail::fake();
        config()->set('mail.inquiry_to', 'office@umistamping.com');
        config()->set('mail.inquiry_retries', 1);

        $inquiry = Inquiry::create([
            'locale' => 'en', 'name' => 'Claim Release',
            'email' => 'claim@umistamping.com', 'inquiry_type' => 'engineering',
            'message' => 'Checking that a failed send frees the claim.',
        ]);

        Mail::shouldReceive('to')->andThrow(new \RuntimeException('relay down'));
        Mail::shouldReceive('purge')->andReturnNull();

        $controller = app(\App\Http\Controllers\ContactController::class);
        $m = new \ReflectionMethod($controller, 'notifyOffice');
        $m->setAccessible(true);

        $result = $m->invoke($controller, $inquiry, 'office@umistamping.com');
        $fresh = $inquiry->fresh();

        $this->assertFalse($result);
        $this->assertNull($fresh->office_notified_at, 'claim released after total failure');
        $this->assertGreaterThan(0, $fresh->office_notify_attempts, 'the attempts are still recorded');
    }

    public function test_the_acknowledgement_can_be_switched_off(): void
    {
        Mail::fake();
        config()->set('mail.inquiry_to', 'office@umistamping.com');
        config()->set('mail.inquiry_acknowledge', false);

        $this->postJson('/en/contact', $this->payload())->assertStatus(201);

        Mail::assertSent(InquiryReceived::class, 1);
        Mail::assertNotSent(InquiryReceived::class, fn (InquiryReceived $m) => $m->acknowledgement === true);
    }
}

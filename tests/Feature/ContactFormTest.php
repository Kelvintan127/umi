<?php

namespace Tests\Feature;

use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * POST /{locale}/contact.
 *
 * The controller's stated contract: the inquiry is persisted before any mail is
 * attempted, and the response never claims a mail was sent when it was not.
 * These tests assert that contract rather than the happy path alone.
 */
class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Putri Engineer',
            'company' => 'Contoh Manufaktur',
            'email' => 'putri@umistamping.com',
            'phone' => '+62 778 464141',
            'inquiry_type' => 'new-project',
            'message' => 'We need battery contacts stamped from 0.15 mm nickel-plated steel.',
            'consent' => '1',
            'elapsed_ms' => 5000,
        ], $overrides);
    }

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('contact:127.0.0.1');
    }

    public function test_a_valid_inquiry_is_persisted_and_redirects_back(): void
    {
        Mail::fake();
        config(['mail.inquiry_to' => 'sales@umistamping.com']);

        // A real Inertia visit, which is what the browser sends: the redirect
        // back carries the flash. A plain form post gets JSON instead, covered
        // by test_an_xhr_post_receives_json.
        $response = $this->withHeaders(['X-Inertia' => 'true', 'X-Inertia-Version' => ''])
            ->post('/en/contact', $this->payload());

        $response->assertRedirect('/en/contact');
        $response->assertSessionHas('inquiry.ok', true);

        $this->assertDatabaseCount('inquiries', 1);

        $inquiry = Inquiry::first();
        $this->assertSame('en', $inquiry->locale);
        $this->assertSame('Putri Engineer', $inquiry->name);
        $this->assertSame('putri@umistamping.com', $inquiry->email);
    }

    public function test_the_internal_notification_is_sent_when_mail_is_configured(): void
    {
        Mail::fake();
        config(['mail.inquiry_to' => 'sales@umistamping.com']);

        $this->post('/en/contact', $this->payload());

        Mail::assertSent(InquiryReceived::class);
    }

    public function test_nothing_is_sent_to_the_recipient_when_mail_is_not_configured(): void
    {
        Mail::fake();
        config(['mail.inquiry_to' => '']);

        $this->post('/en/contact', $this->payload())->assertRedirect();

        Mail::assertNothingSent();
        // The inquiry still survives: a mail misconfiguration must not lose a
        // customer inquiry.
        $this->assertDatabaseCount('inquiries', 1);
        // queued comes back as false, not null: the inquiry is stored but no
        // mail was handed off.
        $this->assertFalse((bool) session('inquiry.queued'));
    }

    public function test_validation_rejects_an_empty_submission(): void
    {
        Mail::fake();

        $this->post('/en/contact', ['elapsed_ms' => 5000])
            ->assertSessionHasErrors(['name', 'email', 'inquiry_type', 'message', 'consent']);

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_validation_rejects_a_malformed_email(): void
    {
        Mail::fake();

        $this->post('/en/contact', $this->payload(['email' => 'not-an-email']))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_validation_rejects_an_unknown_inquiry_type(): void
    {
        Mail::fake();

        $this->post('/en/contact', $this->payload(['inquiry_type' => 'drop-table']))
            ->assertSessionHasErrors('inquiry_type');

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_consent_is_required(): void
    {
        Mail::fake();

        $this->post('/en/contact', $this->payload(['consent' => '']))
            ->assertSessionHasErrors('consent');

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_the_honeypot_is_silently_dropped_without_persisting(): void
    {
        Mail::fake();

        $this->post('/en/contact', $this->payload(['website' => 'http://spam.example']))
            ->assertRedirect();

        // Indistinguishable to the bot, but nothing was stored or mailed.
        $this->assertDatabaseCount('inquiries', 0);
        Mail::assertNothingSent();
    }

    public function test_an_instant_submission_is_treated_as_a_bot(): void
    {
        Mail::fake();

        $this->post('/en/contact', $this->payload(['elapsed_ms' => 10]))
            ->assertRedirect();

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_an_xhr_post_receives_json(): void
    {
        Mail::fake();
        config(['mail.inquiry_to' => 'sales@umistamping.com']);

        $this->postJson('/en/contact', $this->payload())
            ->assertCreated()
            ->assertJson(['ok' => true]);

        $this->assertDatabaseCount('inquiries', 1);
    }

    public function test_the_rate_limiter_blocks_a_burst(): void
    {
        Mail::fake();
        config(['mail.inquiry_to' => 'sales@umistamping.com']);

        $statuses = [];
        for ($i = 0; $i < 15; $i++) {
            $statuses[] = $this->postJson('/en/contact', $this->payload())->getStatusCode();
        }

        $this->assertContains(429, $statuses, 'A burst of 15 submissions should hit the rate limiter.');
    }
}

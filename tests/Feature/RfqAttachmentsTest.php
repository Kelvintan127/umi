<?php

namespace Tests\Feature;

use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RfqAttachmentsTest extends TestCase
{
    use RefreshDatabase;

    private function input(array $overrides = []): array
    {
        return array_merge([
            'name'=>'Manufacturing Buyer', 'email'=>'buyer@umistamping.com',
            'company'=>'Parts Factory', 'inquiry_type'=>'new-project',
            'message'=>'Please review the attached engineering drawing and quote.',
            'consent'=>'1', 'elapsed_ms'=>8000,
        ], $overrides);
    }

    public function test_a_pdf_is_stored_privately_and_attached_to_the_office_email(): void
    {
        Storage::fake('local');
        Mail::fake();
        config(['mail.inquiry_to'=>'sales@umistamping.com']);
        $file = UploadedFile::fake()->createWithContent('bracket.pdf', "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n%%EOF");
        $this->post('/en/contact', $this->input(['attachments'=>[$file]]))->assertRedirect();
        $inquiry = Inquiry::query()->firstOrFail();
        $this->assertCount(1, $inquiry->attachments);
        Storage::disk('local')->assertExists($inquiry->attachments[0]['path']);
        Mail::assertSent(InquiryReceived::class, function (InquiryReceived $email) {
            return ! $email->acknowledgement && count($email->attachments()) === 1;
        });
    }

    public function test_a_fake_executable_renamed_as_dwg_is_rejected(): void
    {
        Storage::fake('local');
        Mail::fake();
        $file = UploadedFile::fake()->createWithContent('drawing.dwg', "MZ\\x90\\x00EXE");
        $this->post('/en/contact', $this->input(['attachments'=>[$file]]))
            ->assertSessionHasErrors('attachments.0');
        $this->assertDatabaseCount('inquiries',0);
    }

    public function test_oversize_attachments_are_rejected(): void
    {
        Storage::fake('local');
        Mail::fake();
        $file = UploadedFile::fake()->createWithContent('drawing.pdf', "%PDF-1.4\n".str_repeat('a', 25*1024*1024));
        $this->post('/en/contact', $this->input(['attachments'=>[$file]]))
            ->assertSessionHasErrors('attachments.0');
        $this->assertDatabaseCount('inquiries',0);
    }

    public function test_an_acknowledgement_never_exposes_attachments(): void
    {
        $inquiry = new Inquiry(['name'=>'Buyer','email'=>'buyer@umistamping.com']);
        $inquiry->attachments = [['path'=>'inquiries/1/secret.pdf','name'=>'secret.pdf','mime'=>'application/pdf','size'=>10]];
        $mail = new InquiryReceived($inquiry, acknowledgement:true, messageLocale:'en');
        $this->assertSame([], $mail->attachments());
    }
}

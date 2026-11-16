<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * One mailable, two audiences. The internal notification (`acknowledgement:
 * false`) goes to the company address in MAIL_INQUIRY_TO; the acknowledgement
 * goes back to the enquirer in their locale.
 *
 * Markdown rather than Blade views: no HTML to maintain, and the plain-text
 * alternative comes for free.
 *
 * The locale is deliberately NOT a promoted property: Illuminate\Mail\Mailable
 * already declares a public non-readonly `$locale`, and re-declaring it here is
 * a fatal error. The language travels as `messageLocale` and is handed to
 * Laravel's own `locale()` in the constructor so the queue and the send path
 * both honour it.
 */
class InquiryReceived extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly Inquiry $inquiry,
        public readonly bool $acknowledgement = false,
        string $messageLocale = 'en',
    ) {
        $this->locale($messageLocale);
    }

    public function envelope(): Envelope
    {
        $from = (string) config('mail.from.address');

        return new Envelope(
            from: new Address($from, (string) config('mail.from.name')),
            replyTo: [new Address($this->inquiry->email, $this->inquiry->name)],
            subject: $this->acknowledgement
                ? (string) trans('forms.ack_subject', [], $this->locale)
                : '[UMI inquiry] '.$this->inquiry->name.' — '.$this->inquiry->inquiry_type,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.inquiry',
            with: [
                'inquiry' => $this->inquiry,
                'acknowledgement' => $this->acknowledgement,
                'body' => (string) trans(
                    $this->acknowledgement ? 'forms.ack_body' : 'forms.internal_body',
                    [],
                    $this->locale,
                ),
            ],
        );
    }
}

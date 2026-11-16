<?php

namespace App\Http\Controllers;

use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use App\Rules\DeliverableEmail;
use App\Support\Locales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Throwable;

/**
 * POST /{locale}/contact.
 *
 * Writes the inquiry first, then attempts delivery. A mail failure is logged and
 * reported to the client as `queued=false` — the inquiry is never lost, and the
 * response never claims a mail was sent when it was not.
 *
 * Anti-spam without a captcha: a honeypot field that must stay empty, a
 * minimum-submit-time field, and the route-level throttle. All three are
 * server-side; the form works with JavaScript disabled.
 */
class ContactController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $locale = (string) $request->route('locale');

        // Honeypot + timing. A bot that fills every field or posts instantly is
        // answered 200 with the normal shape so it cannot tell it was rejected.
        $honeypot = (string) $request->input('website', '');
        $elapsed = (int) $request->input('elapsed_ms', 0);

        if ($honeypot !== '' || $elapsed < 1200) {
            Log::info('contact.rejected', [
                'reason' => $honeypot !== '' ? 'honeypot' : 'too_fast',
                'ip_hash' => hash('sha256', (string) $request->ip()),
            ]);

            return $this->respond($request, [
                'ok' => true,
                'queued' => false,
                'message' => trans('forms.success_body', [], $locale),
            ], 201);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'company' => ['nullable', 'string', 'max:160'],
            'email' => ['required', 'string', 'email:rfc', 'max:190', new DeliverableEmail],
            'phone' => ['nullable', 'string', 'max:60'],
            'inquiry_type' => ['required', 'string', Rule::in(array_keys((array) trans('forms.inquiry_types', [], 'en')))],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'consent' => ['accepted'],
        ]);

        $inquiry = Inquiry::create([
            'locale' => $locale,
            'name' => $data['name'],
            'company' => $data['company'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'inquiry_type' => $data['inquiry_type'],
            'message' => $data['message'],
            'ip_hash' => hash('sha256', (string) $request->ip()),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        $queued = $this->deliver($inquiry, $locale);

        return $this->respond($request, [
            'ok' => true,
            'queued' => $queued,
            'id' => $inquiry->id,
            'message' => trans('forms.success_body', [], $locale),
        ], 201);
    }

    /**
     * Send the two notifications (internal + acknowledgement). Returns whether
     * delivery was actually handed off without error; never asserts success.
     *
     * The two sends are independent. An acknowledgement failing must not prevent
     * the office notification, and vice versa: an inquiry the business never sees
     * is a lost lead, whereas a missing courtesy reply is an inconvenience. So
     * `mail_sent_at` records a successful *internal* notification, which is the
     * one that matters for "did anyone find out about this", and the
     * acknowledgement failure is logged separately.
     */
    private function deliver(Inquiry $inquiry, string $locale): bool
    {
        $to = (string) config('mail.inquiry_to');

        if ($to === '') {
            Log::warning('contact.mail_not_configured', ['inquiry_id' => $inquiry->id]);

            return false;
        }

        $officeNotified = $this->notifyOffice($inquiry, $to);
        $this->acknowledge($inquiry, $locale);

        return $officeNotified;
    }

    /**
     * Tell the office. Exactly once, per inquiry.
     *
     * This is the notification that must not be duplicated — a lead mailed twice
     * wastes the sales team's time and looks broken. The guard is the persisted
     * office_notified_at, not a local flag, so a retried job or a double-submitted
     * form cannot send a second copy.
     */
    private function notifyOffice(Inquiry $inquiry, string $to): bool
    {
        if ($inquiry->officeNotified()) {
            return true;
        }

        $attempts = max(1, (int) config('mail.inquiry_retries', 3));

        for ($attempt = 1; $attempt <= $attempts; $attempt++) {
            try {
                Mail::to($to)->send(new InquiryReceived($inquiry));

                // mail_sent_at is kept in step for anything already reading it;
                // office_notified_at is the authoritative field.
                $inquiry->forceFill([
                    'mail_sent_at' => now(),
                    'office_notified_at' => now(),
                    'office_notify_attempts' => $inquiry->office_notify_attempts + $attempt,
                ])->save();

                return true;
            } catch (Throwable $e) {
                Log::error('contact.mail_failed', [
                    'inquiry_id' => $inquiry->id,
                    'attempt' => $attempt,
                    'of' => $attempts,
                    'exception' => $e::class,
                    'message' => $e->getMessage(),
                ]);

                if ($attempt < $attempts) {
                    // Backoff between attempts; a hard-down relay fails fast and
                    // retrying immediately would just burn the request budget.
                    usleep((int) (config('mail.inquiry_retry_backoff_ms', 250) * 1000 * $attempt));
                }
            }
        }

        // Record the failure so the attempt count survives, but leave
        // office_notified_at null — that field means delivered, not tried.
        $inquiry->forceFill([
            'office_notify_attempts' => min(255, $inquiry->office_notify_attempts + $attempts),
        ])->save();

        return false;
    }

    /**
     * Send the enquirer their confirmation.
     *
     * Deliberately NOT gated on the office notification having succeeded. The two
     * fail for unrelated reasons, and the enquirer's reply is a courtesy that
     * should still go out if the internal relay is misconfigured — the earlier
     * `if ($notified && ...)` meant a broken office address silently suppressed
     * every acknowledgement, which is the wrong way round.
     *
     * The enquiry is already persisted either way, so a failure here loses nothing.
     */
    private function acknowledge(Inquiry $inquiry, string $locale): void
    {
        if (! (bool) config('mail.inquiry_acknowledge', true) || $inquiry->acknowledged()) {
            return;
        }

        try {
            // Symfony's SMTP transport keeps its connection between sends and a
            // relay may close after the first, so the second send can hit a dead
            // socket ("Unable to write bytes on the wire"). Purging forces a
            // fresh connection — harmless against a real relay, and it makes the
            // two notifications independent instead of the second depending on
            // how the first tore down its socket.
            Mail::purge((string) config('mail.default'));

            // The parameter is `messageLocale`, not `locale`: Mailable already
            // owns a public `$locale` property and the mailable avoids shadowing it.
            Mail::to($inquiry->email)->send(new InquiryReceived($inquiry, acknowledgement: true, messageLocale: $locale));

            $inquiry->forceFill(['acknowledged_at' => now()])->save();
        } catch (Throwable $e) {
            // Deliberately not fatal: the business has the inquiry either way.
            Log::warning('contact.acknowledgement_failed', [
                'inquiry_id' => $inquiry->id,
                'exception' => $e::class,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Inertia visits expect a redirect back with flash; an XHR post gets JSON.
     * Both carry the same facts, so no client can infer a send that did not happen.
     *
     * @param  array<string, mixed>  $payload
     */
    private function respond(Request $request, array $payload, int $status): JsonResponse|RedirectResponse
    {
        if ($request->header('X-Inertia')) {
            return redirect()
                ->route('site.contact', ['locale' => (string) $request->route('locale')])
                ->with('inquiry', $payload);
        }

        return response()->json($payload, $status);
    }
}

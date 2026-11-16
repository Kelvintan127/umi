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
     */
    private function deliver(Inquiry $inquiry, string $locale): bool
    {
        $to = (string) config('mail.inquiry_to');

        if ($to === '') {
            Log::warning('contact.mail_not_configured', ['inquiry_id' => $inquiry->id]);

            return false;
        }

        try {
            Mail::to($to)->send(new InquiryReceived($inquiry));

            if ((bool) config('mail.inquiry_acknowledge', true)) {
                Mail::to($inquiry->email)->send(new InquiryReceived($inquiry, acknowledgement: true, locale: $locale));
            }

            return true;
        } catch (Throwable $e) {
            Log::error('contact.mail_failed', [
                'inquiry_id' => $inquiry->id,
                'exception' => $e::class,
                'message' => $e->getMessage(),
            ]);

            return false;
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

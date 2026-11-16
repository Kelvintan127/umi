<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * An email address whose domain can plausibly receive mail.
 *
 * Laravel's `email:rfc,dns` fails closed: a DNS timeout, a resolver hiccup or a
 * domain whose MX lookup is briefly unavailable rejects a real customer. Losing
 * a genuine inquiry costs more than admitting one spam message, so this rule
 * fails *open* when the lookup itself errors, and only rejects when DNS
 * answers clearly and negatively (no MX and no A record — RFC 5321 §5.1 permits
 * delivering to the A record as an implicit MX).
 */
class DeliverableEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '') {
            return;
        }

        $domain = substr(strrchr($value, '@') ?: '', 1);

        if ($domain === '' || ! str_contains($domain, '.')) {
            $fail('The :attribute field must be a valid email address.');

            return;
        }

        try {
            if ($this->hasRecord($domain, 'MX')) {
                return;
            }

            if ($this->hasRecord($domain, 'A') || $this->hasRecord($domain, 'AAAA')) {
                return;
            }
        } catch (Throwable $e) {
            // Resolver unavailable: accept, but leave a trail so a spike is
            // visible rather than silent.
            Log::warning('contact.email_dns_unavailable', [
                'domain' => $domain,
                'exception' => $e::class,
            ]);

            return;
        }

        $fail('The :attribute field must be a deliverable email address.');
    }

    private function hasRecord(string $domain, string $type): bool
    {
        $records = match ($type) {
            'MX' => @dns_get_record($domain, DNS_MX),
            'A' => @dns_get_record($domain, DNS_A),
            'AAAA' => @dns_get_record($domain, DNS_AAAA),
            default => [],
        };

        if ($records === false) {
            throw new \RuntimeException("DNS query for {$type} {$domain} failed.");
        }

        return $records !== [];
    }
}

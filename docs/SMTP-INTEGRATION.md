# SMTP Integration

How the contact form's two notifications behave, and what to configure to make
them real. Nothing here invents credentials.

## Two notifications, one inquiry

| | Office notification | Enquirer acknowledgement |
|---|---|---|
| Recipient | `MAIL_INQUIRY_TO` | the address the enquirer typed |
| Purpose | the business must see the lead | courtesy confirmation |
| State field | `office_notified_at` | `acknowledged_at` |
| Duplicate safe | **yes — this is the one that must be exactly-once** | yes, guarded by its own field |
| Failure impact | lost lead if nobody notices | enquirer cannot tell "ignored" from "broken mailbox" |
| Retries | `MAIL_INQUIRY_RETRIES` (default 3) with linear backoff | none, single attempt |

They are independent in both directions. A failed office send does not suppress
the acknowledgement, and a failed acknowledgement does not make the site claim
the inquiry was undelivered.

## The inquiry is saved before any mail is attempted

`Inquiry::create()` runs first, unconditionally. Every failure path after that —
relay down, bad recipient, timeout, misconfiguration — leaves the row intact.
The database is the record of truth; email is a notification about it.

    POST /en/contact
      → validate
      → persist inquiry            ← the lead is now safe, no matter what follows
      → claim office send          ← atomic UPDATE, one winner
      → send office notification   ← retries, then releases claim on total failure
      → send acknowledgement       ← independent, single attempt

## Duplicate prevention under concurrency

The guard is a conditional UPDATE, not a check-then-act:

```php
$claimed = Inquiry::whereKey($id)
    ->whereNull('office_notified_at')
    ->update(['office_notified_at' => now()]);

if ($claimed === 0) {
    // another request won the claim; do not send
}
```

A read-then-write guard would let two requests both observe `null` and both send.
The conditional UPDATE makes the database the arbiter, so a double-submitted form,
a retried queue job, or two PHP-FPM workers on the same record produce exactly one
office email.

If every retry fails, the claim is released (`office_notified_at` back to null)
while `office_notify_attempts` keeps the count. An outage therefore does not mark
a lead permanently un-notifiable; a later attempt can still deliver it.

## Configuration for a real provider

Put these in `.env` on the target host. **Never commit them.**

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.your-provider.example
MAIL_PORT=587
MAIL_SCHEME=tls
MAIL_USERNAME=your-smtp-user
MAIL_PASSWORD=your-smtp-password
MAIL_FROM_ADDRESS=noreply@umistamping.com
MAIL_FROM_NAME="PT. Uni-Metaltech Website"

MAIL_INQUIRY_TO=office@umistamping.com
MAIL_INQUIRY_ACKNOWLEDGE=true
MAIL_INQUIRY_RETRIES=3
MAIL_INQUIRY_RETRY_BACKOFF_MS=250
```

Provider-specific notes:

- **Port 587 + `MAIL_SCHEME=tls`** (STARTTLS) is the usual choice. Port 465 wants
  `MAIL_SCHEME=smtps`.
- **Sender domain must be authorised.** `MAIL_FROM_ADDRESS` should be on a domain
  with SPF and DKIM records the provider has issued. Sending as a domain you do
  not control gets the mail binned as spoofing.
- **The enquiry acknowledgement goes to arbitrary addresses**, so the provider
  must tolerate variable recipients. Some transactional providers restrict this;
  check before assuming.
- **Rate limits are per provider**, commonly a few hundred an hour. The form is
  also throttled at `throttle:5,1` per IP, which is the tighter limit in practice.

## Verifying without sending to a real customer

`tools/smtp_sink.py` is a dependency-free SMTP server for exactly this. It speaks
enough SMTP for Laravel's transport and writes each message to disk.

```bash
python3 tools/smtp_sink.py --port 2526 --outdir /tmp/smtp-test
```

Point `.env` at it, submit the form, and read the captured `.eml` files. Two
messages should appear: one to the office address, one to the enquirer.

To test the failure path, add `--fail-recipients`. The sink then rejects every
recipient, which exercises retries and the claim-release logic.

Verified against this sink at commit `9db8ee6`:

- one submission → exactly 2 messages, one to each recipient
- `office_notified_at` and `acknowledged_at` set independently
- rejection path → inquiry persisted, both timestamps null, 3 attempts logged,
  no message delivered anywhere

## What has not been verified

**Delivery through a real provider.** No SMTP credentials exist in this
environment. Every claim above is against a local SMTP server, not a provider's
infrastructure. Real delivery — DNS, SPF/DKIM alignment, spam placement,
provider rate limits — is unproven until someone runs it with real credentials.

Do not read "SMTP integration prepared" as "email works". The code path is
proven; the transport is not.

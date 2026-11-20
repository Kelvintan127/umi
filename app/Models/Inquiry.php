<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A website inquiry. Written before any mail attempt, so a delivery failure
 * degrades to "we have it, nobody was emailed" rather than data loss.
 *
 * `ip_hash` is a salted SHA-256 of the client IP — enough to spot abuse
 * patterns, not a stored IP address.
 */
class Inquiry extends Model
{
    protected $fillable = [
        'locale',
        'name',
        'company',
        'email',
        'phone',
        'inquiry_type',
        'message',
        'ip_hash',
        'user_agent',
        'mail_sent_at',
        'attachments',
    ];

    /** True once the office has actually been told. Drives exactly-once send. */
    public function officeNotified(): bool
    {
        return $this->office_notified_at !== null;
    }

    /** True once the enquirer has their confirmation. Independent of the above. */
    public function acknowledged(): bool
    {
        return $this->acknowledged_at !== null;
    }

    protected function casts(): array
    {
        return [
            'mail_sent_at' => 'datetime',
            'attachments' => 'array',
            'office_notified_at' => 'datetime',
            'acknowledged_at' => 'datetime',
            'office_notify_attempts' => 'integer',
        ];
    }
}

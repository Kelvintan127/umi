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
    ];

    protected function casts(): array
    {
        return [
            'mail_sent_at' => 'datetime',
        ];
    }
}

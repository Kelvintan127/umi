<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Track the two notifications independently.
 *
 * There was a single mail_sent_at, which could only ever answer "did something
 * go out". The office notification and the enquirer's acknowledgement fail for
 * different reasons and get fixed by different people, so they need separate
 * state — otherwise retrying one looks like it succeeded because the other did.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            // When the internal notification reached the office. This is the
            // one that has to be exactly-once.
            $table->timestamp('office_notified_at')->nullable()->after('mail_sent_at');

            // When the enquirer got their confirmation. Null here with a
            // non-null office_notified_at is a normal, non-urgent state: the
            // business already has the lead.
            $table->timestamp('acknowledged_at')->nullable()->after('office_notified_at');

            // Counts failed sends so a retried job does not re-notify the
            // office. Bounded by config.
            $table->unsignedTinyInteger('office_notify_attempts')->default(0)->after('acknowledged_at');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['office_notified_at', 'acknowledged_at', 'office_notify_attempts']);
        });
    }
};

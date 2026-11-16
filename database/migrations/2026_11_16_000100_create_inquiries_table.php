<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->index();
            $table->string('name', 120);
            $table->string('company', 160)->nullable();
            $table->string('email', 190);
            $table->string('phone', 60)->nullable();
            $table->string('inquiry_type', 40)->index();
            $table->text('message');
            $table->string('ip_hash', 64)->nullable();
            $table->string('user_agent', 255)->nullable();
            // Set only when a notification was actually handed to the mailer.
            $table->timestamp('mail_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};

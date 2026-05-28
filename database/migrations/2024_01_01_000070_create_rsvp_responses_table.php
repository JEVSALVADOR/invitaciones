<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rsvp_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('guest_id')->nullable()->constrained('event_guests')->onDelete('set null');
            $table->string('respondent_name', 200);
            $table->enum('attendance_option', ['solo_yo', 'yo_y_pareja', 'no_asistire']);
            $table->integer('total_attendees')->default(1);
            $table->text('message')->nullable();
            $table->string('phone_contact', 20)->nullable();
            $table->timestamp('responded_at')->useCurrent();
            $table->string('ip_address', 45)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rsvp_responses');
    }
};

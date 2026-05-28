<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('guest_name', 200);
            $table->string('guest_slug', 300)->nullable()->unique();
            $table->integer('seats_reserved')->default(1);
            $table->string('phone', 20)->nullable();
            $table->string('email', 200)->nullable();
            $table->text('personal_message')->nullable();
            $table->boolean('invitation_sent')->default(false);
            $table->timestamp('invitation_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_guests');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('theme_id')->constrained('themes');
            $table->enum('event_type', ['boda', 'quinceanera', 'cumpleanos', 'aniversario', 'otro']);

            $table->string('main_name', 200);
            $table->string('second_name', 200)->nullable();
            $table->string('event_title_custom', 300)->nullable();

            $table->date('event_date');
            $table->time('ceremony_time')->nullable();
            $table->time('reception_time')->nullable();

            $table->text('love_message')->nullable();
            $table->text('bible_verse')->nullable();
            $table->string('bible_reference', 50)->nullable();

            $table->boolean('show_music_player')->default(true);
            $table->boolean('show_dress_code')->default(true);
            $table->boolean('show_gift_suggestion')->default(true);
            $table->boolean('show_recommendations')->default(true);
            $table->boolean('show_rsvp')->default(true);
            $table->boolean('show_countdown')->default(true);
            $table->boolean('show_itinerary')->default(true);

            $table->text('dress_code_general')->nullable();
            $table->text('dress_code_women')->nullable();
            $table->text('dress_code_men')->nullable();

            $table->text('gift_suggestion_text')->nullable();
            $table->json('recommendations')->nullable();

            $table->string('contact_whatsapp', 20)->nullable();
            $table->string('contact_name', 100)->nullable();

            $table->string('song_title', 200)->nullable();
            $table->string('song_artist', 200)->nullable();
            $table->string('song_file_path', 500)->nullable();

            $table->boolean('is_published')->default(false);
            $table->integer('total_seats')->default(0);
            $table->integer('confirmed_seats')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

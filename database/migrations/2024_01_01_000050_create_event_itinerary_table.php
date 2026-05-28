<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_itinerary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('time_label', 20);
            $table->time('event_time');
            $table->string('activity_name', 200);
            $table->enum('icon_type', [
                'church', 'camera', 'reception_table', 'flowers_table',
                'car', 'ring', 'cake', 'party', 'dance', 'dinner', 'toast', 'custom'
            ])->default('church');
            $table->enum('position', ['left', 'right'])->default('right');
            $table->integer('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_itinerary');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('primary_color', 7)->default('#1e3a5f');
            $table->string('secondary_color', 7)->default('#4a90d9');
            $table->string('accent_color', 7)->default('#c9a84c');
            $table->string('background_color', 7)->default('#f5f5f0');
            $table->string('text_color', 7)->default('#2c2c2c');
            $table->string('font_script', 100)->default('Great Vibes');
            $table->string('font_display', 100)->default('Playfair Display');
            $table->string('font_body', 100)->default('Lato');
            $table->enum('floral_style', ['navy_blue', 'pink_roses', 'gold_garden', 'rustic', 'tropical'])->default('navy_blue');
            $table->string('envelope_color', 7)->default('#1e3a5f');
            $table->string('seal_color', 7)->default('#c9a84c');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};

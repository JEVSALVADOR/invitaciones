<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('color_primary',   20)->nullable()->after('theme_id');
            $table->string('color_secondary', 20)->nullable()->after('color_primary');
            $table->string('color_accent',    20)->nullable()->after('color_secondary');
            $table->string('color_bg',        20)->nullable()->after('color_accent');
            $table->string('color_text',      20)->nullable()->after('color_bg');
            $table->string('color_envelope',  20)->nullable()->after('color_text');
            $table->string('color_seal',      20)->nullable()->after('color_envelope');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['color_primary','color_secondary','color_accent','color_bg','color_text','color_envelope','color_seal']);
        });
    }
};

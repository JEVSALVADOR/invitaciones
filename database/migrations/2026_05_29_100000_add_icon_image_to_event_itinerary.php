<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_itinerary', function (Blueprint $table) {
            $table->string('icon_image')->nullable()->after('icon_type');
        });
    }

    public function down(): void
    {
        Schema::table('event_itinerary', function (Blueprint $table) {
            $table->dropColumn('icon_image');
        });
    }
};

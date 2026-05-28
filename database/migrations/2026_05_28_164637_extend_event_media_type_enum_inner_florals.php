<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE event_media MODIFY COLUMN media_type ENUM(
            'photo_main','photo_second','photo_third','photo_gallery',
            'floral_top_left','floral_bottom_right','floral_envelope',
            'floral_divider','floral_cal_tl','floral_cal_br'
        ) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE event_media MODIFY COLUMN media_type ENUM(
            'photo_main','photo_second','photo_third','photo_gallery',
            'floral_top_left','floral_bottom_right','floral_envelope'
        ) NOT NULL");
    }
};

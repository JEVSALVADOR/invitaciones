<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            [
                'name'             => 'Azul Marino Elegante',
                'slug'             => 'navy-blue-elegant',
                'primary_color'    => '#1e3a5f',
                'secondary_color'  => '#4a90d9',
                'accent_color'     => '#c9a84c',
                'background_color' => '#f5f5f0',
                'text_color'       => '#2c2c2c',
                'font_script'      => 'Great Vibes',
                'font_display'     => 'Playfair Display',
                'font_body'        => 'Lato',
                'floral_style'     => 'navy_blue',
                'envelope_color'   => '#1e3a5f',
                'seal_color'       => '#c9a84c',
            ],
            [
                'name'             => 'Rosa Romántico',
                'slug'             => 'pink-romantic',
                'primary_color'    => '#8b2252',
                'secondary_color'  => '#d4608a',
                'accent_color'     => '#d4a853',
                'background_color' => '#fdf6f0',
                'text_color'       => '#3d2b1f',
                'font_script'      => 'Pinyon Script',
                'font_display'     => 'Cormorant Garamond',
                'font_body'        => 'Nunito',
                'floral_style'     => 'pink_roses',
                'envelope_color'   => '#8b2252',
                'seal_color'       => '#d4a853',
            ],
            [
                'name'             => 'Dorado Jardín',
                'slug'             => 'gold-garden',
                'primary_color'    => '#4a3520',
                'secondary_color'  => '#8b7355',
                'accent_color'     => '#c9a84c',
                'background_color' => '#faf8f5',
                'text_color'       => '#2c2c2c',
                'font_script'      => 'Alex Brush',
                'font_display'     => 'EB Garamond',
                'font_body'        => 'Source Serif 4',
                'floral_style'     => 'gold_garden',
                'envelope_color'   => '#4a3520',
                'seal_color'       => '#c9a84c',
            ],
        ];

        foreach ($themes as $theme) {
            Theme::firstOrCreate(['slug' => $theme['slug']], $theme);
        }
    }
}

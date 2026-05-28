<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    protected $fillable = [
        'name', 'slug', 'primary_color', 'secondary_color', 'accent_color',
        'background_color', 'text_color', 'font_script', 'font_display', 'font_body',
        'floral_style', 'envelope_color', 'seal_color', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

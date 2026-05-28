<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'uuid', 'theme_id', 'event_type', 'main_name', 'second_name', 'event_title_custom',
        'event_date', 'ceremony_time', 'reception_time',
        'love_message', 'bible_verse', 'bible_reference',
        'show_music_player', 'show_dress_code', 'show_gift_suggestion',
        'show_recommendations', 'show_rsvp', 'show_countdown', 'show_itinerary',
        'dress_code_general', 'dress_code_women', 'dress_code_men',
        'gift_suggestion_text', 'recommendations',
        'contact_whatsapp', 'contact_name',
        'song_title', 'song_artist', 'song_file_path',
        'is_published', 'total_seats', 'confirmed_seats',
        'color_primary', 'color_secondary', 'color_accent',
        'color_bg', 'color_text', 'color_envelope', 'color_seal',
        'seal_initials', 'general_invite_message',
    ];

    protected $casts = [
        'event_date'        => 'date',
        'recommendations'   => 'array',
        'is_published'      => 'boolean',
        'show_music_player' => 'boolean',
        'show_dress_code'   => 'boolean',
        'show_gift_suggestion' => 'boolean',
        'show_recommendations' => 'boolean',
        'show_rsvp'         => 'boolean',
        'show_countdown'    => 'boolean',
        'show_itinerary'    => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($event) {
            if (empty($event->uuid)) {
                $event->uuid = (string) Str::uuid();
            }
        });
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(EventMedia::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(EventLocation::class)->orderBy('sort_order');
    }

    public function itinerary(): HasMany
    {
        return $this->hasMany(EventItinerary::class)->orderBy('sort_order');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(EventGuest::class);
    }

    public function rsvpResponses(): HasMany
    {
        return $this->hasMany(RsvpResponse::class);
    }

    public function mainPhoto(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'photo_main');
    }

    public function secondPhoto(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'photo_second');
    }

    public function thirdPhoto(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'photo_third');
    }

    public function floralTopLeft(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'floral_top_left');
    }

    public function floralBottomRight(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'floral_bottom_right');
    }

    public function floralEnvelope(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'floral_envelope');
    }

    public function floralDivider(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'floral_divider');
    }

    public function floralCalTl(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'floral_cal_tl');
    }

    public function floralCalBr(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'floral_cal_br');
    }

    public function sealClosed(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'seal_closed');
    }

    public function sealOpen(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'seal_open');
    }

    public function tornTop(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'torn_top');
    }

    public function tornBottom(): HasOne
    {
        return $this->hasOne(EventMedia::class)->where('media_type', 'torn_bottom');
    }

    public function getEventTitleAttribute(): string
    {
        if ($this->event_title_custom) {
            return $this->event_title_custom;
        }
        return match ($this->event_type) {
            'boda'        => "Boda de {$this->main_name} & {$this->second_name}",
            'quinceanera' => "XV Años de {$this->main_name}",
            'cumpleanos'  => "Cumpleaños de {$this->main_name}",
            'aniversario' => "Aniversario de {$this->main_name} & {$this->second_name}",
            default       => $this->main_name,
        };
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('event_type', $type);
    }
}

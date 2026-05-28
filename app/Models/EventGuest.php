<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class EventGuest extends Model
{
    protected $fillable = [
        'event_id', 'guest_name', 'guest_slug', 'seats_reserved',
        'phone', 'email', 'personal_message', 'invitation_sent', 'invitation_sent_at',
    ];

    protected $casts = [
        'invitation_sent'    => 'boolean',
        'invitation_sent_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($guest) {
            if (empty($guest->guest_slug)) {
                $base = Str::slug($guest->guest_name);
                $slug = $base . '-' . $guest->id;
                $guest->updateQuietly(['guest_slug' => $slug]);
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function rsvpResponse(): HasOne
    {
        return $this->hasOne(RsvpResponse::class, 'guest_id');
    }
}

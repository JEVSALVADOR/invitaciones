<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RsvpResponse extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'event_id', 'guest_id', 'respondent_name', 'attendance_option',
        'total_attendees', 'message', 'phone_contact', 'responded_at', 'ip_address',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(EventGuest::class, 'guest_id');
    }
}

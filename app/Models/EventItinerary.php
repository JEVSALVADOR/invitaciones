<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventItinerary extends Model
{
    protected $table = 'event_itinerary';

    public $timestamps = false;

    protected $fillable = [
        'event_id', 'time_label', 'event_time', 'activity_name',
        'icon_type', 'position', 'sort_order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}

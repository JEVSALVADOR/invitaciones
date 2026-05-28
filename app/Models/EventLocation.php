<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventLocation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'event_id', 'location_type', 'venue_name', 'address',
        'city', 'google_maps_url', 'latitude', 'longitude',
        'event_time', 'sort_order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'latitude'   => 'decimal:8',
        'longitude'  => 'decimal:8',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}

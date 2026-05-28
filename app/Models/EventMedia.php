<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventMedia extends Model
{
    protected $table = 'event_media';

    public $timestamps = false;

    protected $fillable = ['event_id', 'media_type', 'file_path', 'alt_text', 'sort_order'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}

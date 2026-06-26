<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripStop extends Model
{
    protected $fillable = ['trip_id', 'city', 'terminal', 'stop_order', 'arrival_time', 'departure_time'];

    protected $casts = [
        'arrival_time' => 'string',
        'departure_time' => 'string',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}

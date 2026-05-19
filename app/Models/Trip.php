<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'departure_time', 'arrival_time', 'bus_id',
        'departure_terminal', 'departure_city', 'departure_date',
        'arrival_terminal', 'arrival_city', 'arrival_date',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'departure_date' => 'date:Y-m-d',
        'arrival_date' => 'date:Y-m-d',
    ];

    protected $table = 'trips';

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'trip_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $primaryKey = 'folio';
    protected $table = 'tickets';

    protected $fillable = ['trip_id', 'seat_number', 'passenger_name', 'email', 'sale_date'];

    protected $casts = [
        'sale_date' => 'date:Y-m-d',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'id');
    }
}

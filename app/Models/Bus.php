<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['seat_count', 'decks', 'model_year', 'serial_number', 'driver_id'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function seatsPerDeck(): int
    {
        return (int) ceil($this->seat_count / $this->decks);
    }
}

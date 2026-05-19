<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'routes';
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = ['city', 'departure_time', 'date'];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];
}

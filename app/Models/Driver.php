<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'gender', 'age', 'phone'];
    protected $table = 'drivers';

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }
}

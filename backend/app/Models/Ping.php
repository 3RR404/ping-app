<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ping extends Model
{
    public $timestamps = false;

    protected $fillable = ['uuid', 'battery_percent'];

    protected $casts = [
        'battery_percent' => 'float',
        'created_at' => 'datetime',
    ];
}
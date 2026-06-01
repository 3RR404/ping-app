<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ping extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['device_id', 'battery_percent'];

    protected $casts = [
        'battery_percent' => 'float',
        'created_at' => 'datetime',
    ];

    public function device(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}

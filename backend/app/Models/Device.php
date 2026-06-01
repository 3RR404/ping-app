<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read null|int $lastBatteryPercentage
 */
class Device extends Model
{
    use HasUuids;

    protected $fillable = ['uuid', 'name'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function pings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ping::class);
    }

    public function getLastBatteryPercentageAttribute(): ?int
    {
        return $this->pings()->latest()->first()?->battery_percent;
    }
}

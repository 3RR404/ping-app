<?php

namespace App\Repositories\Ping;

use App\Dtos\PingDto;
use App\Models\Device;
use App\Models\Ping;

class PingRepository implements PingRepositoryInterface
{
    public function store(PingDto $data): void
    {
        $device = Device::query()->where('uuid', $data->uuid)->firstOrFail();

        Ping::query()->createOrFirst([
            'device_id' => $device->id,
            'battery_percent' => $data->batteryPercent,
        ]);
    }
}

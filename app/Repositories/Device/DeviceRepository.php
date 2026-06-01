<?php

namespace App\Repositories\Device;

use App\Dtos\DeviceDto;
use App\Models\Device;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DeviceRepository implements DeviceRepositoryInterface
{
    public function store(DeviceDto $data): Device
    {
        return Device::query()->createOrFirst([
            'uuid' => $data->uuid,
            'name' => $data->name,
        ]);
    }

    public function getDeviceByUuid(string $uuid): Device
    {
        return Device::query()->where('uuid', $uuid)->firstOrFail();
    }

    public function getDevices(): Collection
    {
        return Device::query()->get();
    }
}

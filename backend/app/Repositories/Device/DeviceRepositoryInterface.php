<?php

namespace App\Repositories\Device;

use App\Dtos\DeviceDto;
use App\Models\Device;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface DeviceRepositoryInterface
{
    public function store(DeviceDto $data): Device;
    public function getDeviceByUuid(string $uuid): Device;

    /**
     * @return Collection<Device>
     */
    public function getDevices(): Collection;
}

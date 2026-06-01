<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeviceDetailResource;
use App\Repositories\Device\DeviceRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceDetailController extends Controller
{
    public function __invoke(string $uuid, DeviceRepositoryInterface $deviceRepository): JsonResource
    {
        $device = $deviceRepository->getDeviceByUuid($uuid);

        return DeviceDetailResource::make($device);
    }
}

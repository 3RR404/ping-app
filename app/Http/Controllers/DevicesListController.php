<?php

namespace App\Http\Controllers;

use App\Http\Resources\DevicesListResource;
use App\Repositories\Device\DeviceRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class DevicesListController extends Controller
{
    public function __invoke(DeviceRepositoryInterface $deviceRepository): JsonResource
    {
        return DevicesListResource::collection($deviceRepository->getDevices());
    }
}

<?php

namespace App\Http\Controllers;

use App\Dtos\PingDto;
use App\Http\Requests\PingStoreRequest;
use App\Http\Resources\PingStoreResource;
use App\Repositories\Ping\PingRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class PingStoreController extends Controller
{
    public function __invoke(
        string $uuid,
        PingStoreRequest $request,
        PingRepositoryInterface $pingRepository,
    ): JsonResource {
        $dtoData = new PingDto(
            uuid: $uuid,
            batteryPercent: $request->input('battery_percent'),
        );

        $pingRepository->store($dtoData);

        return PingStoreResource::make([]);
    }
}

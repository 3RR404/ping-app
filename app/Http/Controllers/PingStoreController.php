<?php

namespace App\Http\Controllers;

use App\Dtos\PingDto;
use App\Http\Requests\PingStoreRequest;
use App\Http\Resources\PingStoreResource;
use App\Repositories\Ping\PingRepositoryInterface;
use App\Swagger\Attributes\PostEndpoint;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[PostEndpoint(
    path: '/api/devices/{uuid}/pings/',
    operationId: 'storePing',
    description: 'Store ping',
    summary: 'Store ping',
    tags: ['Devices'],
    requestBody: new OA\RequestBody(
        content: new OA\JsonContent(ref: PingStoreRequest::class),
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: 'Ping created',
            content: new OA\JsonContent(ref: PingStoreResource::class),
        ),
    ],
)]
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

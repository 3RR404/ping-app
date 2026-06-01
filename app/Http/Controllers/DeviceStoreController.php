<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceStoreRequest;
use App\Http\Resources\DeviceStoreResponse;
use App\Repositories\Device\DeviceRepositoryInterface;
use App\Swagger\Attributes\PostEndpoint;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[PostEndpoint(
    path: '/api/devices/',
    operationId: 'storeDevice',
    description: 'Store device',
    summary: 'Store device',
    tags: ['Devices'],
    requestBody: new OA\RequestBody(
        content: new OA\JsonContent(ref: DeviceStoreRequest::class),
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: 'Device created',
            content: new OA\JsonContent(ref: DeviceStoreResponse::class),
        ),
    ],
)]
class DeviceStoreController extends Controller
{
    public function __invoke(DeviceStoreRequest $request, DeviceRepositoryInterface $deviceRepository): JsonResource
    {
        $dto = new \App\Dtos\DeviceDto(
            uuid: $request->input('uuid'),
            name: $request->input('name')
        );

        $device = $deviceRepository->store($dto);

        return DeviceStoreResponse::make($device);
    }
}

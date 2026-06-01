<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeviceDetailResource;
use App\Repositories\Device\DeviceRepositoryInterface;
use App\Swagger\Attributes\GetEndpoint;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[GetEndpoint(
    path: '/api/devices/{uuid}',
    operationId: 'getDeviceDetail',
    description: 'Get device detail by uuid',
    summary: 'Get device detail',
    tags: ['Devices'],
    parameters: [
        new OA\Parameter(
            name: 'uuid',
            description: 'Device uuid',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'string'),
            example: '550e8400-e29b-41d4-a716-446655440000',
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Device detail',
            content: new OA\JsonContent(ref: DeviceDetailResource::class),
        ),
    ],
)]
class DeviceDetailController extends Controller
{
    public function __invoke(string $uuid, DeviceRepositoryInterface $deviceRepository): JsonResource
    {
        $device = $deviceRepository->getDeviceByUuid($uuid);

        return DeviceDetailResource::make($device);
    }
}

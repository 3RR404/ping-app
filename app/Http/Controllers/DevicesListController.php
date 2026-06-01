<?php

namespace App\Http\Controllers;

use App\Http\Resources\DevicesListResource;
use App\Repositories\Device\DeviceRepositoryInterface;
use App\Swagger\Attributes\GetEndpoint;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[GetEndpoint(
    path: '/api/devices/',
    operationId: 'getDeviceList',
    description: 'Get device list',
    summary: 'Get device list',
    tags: ['Devices'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Successful operation',
            content: new OA\JsonContent(
                type: 'array',
                items: new OA\Items(ref: DevicesListResource::class),
            ),
        ),
    ],
)]
class DevicesListController extends Controller
{
    public function __invoke(DeviceRepositoryInterface $deviceRepository): JsonResource
    {
        return DevicesListResource::collection($deviceRepository->getDevices());
    }
}

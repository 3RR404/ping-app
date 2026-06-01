<?php

namespace App\Http\Resources;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @mixin Device
 */
#[OA\Schema(
    schema: 'DevicesListResource',
    properties: [
        new OA\Property(property: 'uuid', type: 'string', example: '550e8400-e29b-41d4-a716-446655440000'),
        new OA\Property(property: 'name', type: 'string', example: 'Device 1'),
        new OA\Property(property: 'last_battery_percenatge', type: 'integer', example: 100),
    ],
)]
class DevicesListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'last_battery_percenatge' => $this->lastBatteryPercentage,
        ];
    }
}

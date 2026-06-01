<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PingStoreResource',
    properties: [
        new OA\Property(property: 'status', type: 'string', example: 'ok'),
    ],
)]
class PingStoreResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'status' => 'ok'
        ];
    }
}

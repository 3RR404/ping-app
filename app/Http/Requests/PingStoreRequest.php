<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PingStoreRequest',
    required: ['battery_percent'],
    properties: [
        new OA\Property(property: 'battery_percent', type: 'number', example: 100),
    ],
)]
class PingStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'battery_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}

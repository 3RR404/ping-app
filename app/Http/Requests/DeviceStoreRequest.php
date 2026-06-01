<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required|uuid',
            'name' => 'required|string|max:255',
        ];
    }
}

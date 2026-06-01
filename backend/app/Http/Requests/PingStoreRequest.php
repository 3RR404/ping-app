<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PingStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'battery_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}

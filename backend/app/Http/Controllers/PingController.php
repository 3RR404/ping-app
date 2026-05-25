<?php

namespace App\Http\Controllers;

use App\Models\Ping;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PingController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'uuid' => 'required|string',
            'battery_percent' => 'required|numeric',
        ]);

        Ping::create($request->only('uuid', 'battery_percent'));

        return response()->json(['status' => 'ok']);
    }
}
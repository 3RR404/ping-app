<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/devices'], static function () {
    Route::post('/', Controllers\DeviceStoreController::class);
    Route::get('/', Controllers\DevicesListController::class);
    Route::get('/{uuid}', Controllers\DeviceDetailController::class);
    Route::post('/{uuid}/ping', Controllers\PingStoreController::class);
});

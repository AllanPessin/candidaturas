<?php

use App\Http\Controllers as Api;
use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Auth\AuthController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [Auth\AuthController::class, 'logout']);

    Route::apiResource('statuses', Api\StatusController::class);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

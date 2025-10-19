<?php

use App\Http\Controllers as Api;
use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Auth\AuthController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [Auth\AuthController::class, 'logout']);

    Route::apiResource('statuses', Api\StatusController::class);
    Route::apiResource('cities', Api\CityController::class);
    Route::apiResource('categories', Api\CategoryController::class);
    Route::delete('modalities/destroy-many', [Api\ModalitiesController::class, 'destroyMany'])
        ->name('modalities.destroy-many');
    Route::apiResource('modalities', Api\ModalitiesController::class);
    Route::apiResource('companies', Api\CompanyController::class);
    Route::apiResource('contracts', Api\ContractController::class);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

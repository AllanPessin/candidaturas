<?php

use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Auth\LoginController::class], 'authenticate');
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return response('api works fine!');
});

Route::prefix('docs')->group(function () {
    Route::get('/swagger', function () {
        return response()->file(base_path('.docs/swagger.json'));
    });
    Route::get('/', function () {
        return view('docs.docs');
    });
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\RegisterController;
//use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\api\KotaController;
use App\Http\Controllers\Api\PropinsiController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/register', RegisterController::class);
Route::post('auth/login', \App\Http\Controllers\Api\Auth\LoginController::class);
//Route::resource('kota', \App\Http\Controllers\Api\KotaController::class)->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
Route::get('/user', function (Request $request) {
    return $request->user();
    });
        Route::prefix('kota')->group(function () {
        Route::get('/', [KotaController::class, 'index']); // list
        Route::post('/', [KotaController::class, 'store']); // create
        Route::get('/{id}', [KotaController::class, 'show']); // detail
        Route::put('/{id}', [KotaController::class, 'update']); // update
        Route::delete('/{id}', [KotaController::class, 'destroy']); // delete
    });
    Route::get('/propinsi', [PropinsiController::class, 'index']);
});
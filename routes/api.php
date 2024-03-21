<?php

use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\CityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/province')->group(function () {
    Route::get('', [ProvinceController::class, 'index']);
    Route::post('', [ProvinceController::class, 'create']);
    Route::get('/{id}', [ProvinceController::class, 'detail']);
    Route::put('/{id}', [ProvinceController::class, 'update']);
    Route::patch('/{id}', [ProvinceController::class, 'patch']);
    Route::delete('/{id}', [ProvinceController::class, 'delete']);
});

Route::prefix('/city')->group(function () {
    Route::get('', [CityController::class, 'index']);
    Route::post('', [CityController::class, 'create']);
    Route::get('/{id}', [CityController::class, 'detail']);
    Route::put('/{id}', [CityController::class, 'update']);
    Route::patch('/{id}', [CityController::class, 'patch']);
    Route::delete('/{id}', [CityController::class, 'delete']);
});

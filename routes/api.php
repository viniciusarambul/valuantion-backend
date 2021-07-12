<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ValuationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('configurations', [ConfigurationController::class, 'index']);
Route::get('configuration/{id}', [ConfigurationController::class, 'show']);
Route::post('configuration', [ConfigurationController::class, 'store']);
Route::put('configuration/{id}', [ConfigurationController::class, 'update']);
Route::delete('configurations/{id}', [ConfigurationController::class, 'destroy']);

Route::post('valuation', [ValuationController::class, 'GetInfoFormulario']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});
<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::group(['middleware' => 'api', 'prefix' => 'reports'], function ($router) {
    Route::post('/create', [ReportsController::class, 'create']);
    Route::get('/list', [ReportsController::class, 'list']);
    Route::post('{id}/update',[ReportsController::class,'update']);
    Route::get('{id}/delete', [ReportsController::class, 'delete']);
    Route::get('{id}/show', [ReportsController::class, 'show']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

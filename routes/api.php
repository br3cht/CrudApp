<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClienteController;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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
Route::post('/auth/login',[AuthController::class,'login']);
Route::post('/auth/register',[AuthController::class, 'register']);
Route::post('/auth/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('auth/user', function (Request $request) {
    return $request->user();
});

// para fins de relaziar teste usar a api
Route::middleware('api')->group(function () {
    Route::resource('/relatorio', RelatorioController::class,[
        'except' => ['edit','index','store','destroy','update']
    ]);

    Route::resource('/user', UserController::class);

    Route::resource('/cliente',ClienteController::class);
});

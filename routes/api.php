<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\ArticleController;
use App\Http\Controllers\api\v1\WeatherController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('article', [ArticleController::class, 'store']);
    Route::get('article-show/{id}', [ArticleController::class, 'show']);
    Route::post('article-update/{id}', [ArticleController::class, 'update']);
    Route::delete('article-delete/{id}', [ArticleController::class, 'delete']);
});
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('data', [\App\Http\Controllers\api\v1\DataController::class, 'all']);

Route::get('weather',[WeatherController::class,'weather']);

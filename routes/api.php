<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\Word\SearchWordController;

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

Route::get('/', function () {
    return response()->json(['message' => 'Fullstack Challenge 🏅 - Dictionary']);
});

Route::middleware('api')->prefix('/auth')->group(function () {
    Route::post('/signin', AuthController::class);
    Route::post('/signup', CreateUserController::class);
});

Route::middleware(['api', 'auth'])->prefix('entries/en')->group(function () {
    Route::post('/{word}/favorite', [FavoriteController::class, 'favorite']);
    Route::delete('/{word}/unfavorite', [FavoriteController::class, 'unfavorite']);
    Route::get('/{word}', SearchWordController::class)->middleware(['save.history.words', 'cache.hit']);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AtmosphereController;



Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('atmospheres', [AtmosphereController::class, 'index']);
    Route::post('atmospheres', [AtmosphereController::class, 'store']);
    Route::get('atmospheres/{atmosphere}', [AtmosphereController::class, 'show']);
    Route::put('atmospheres/{atmosphere}', [AtmosphereController::class, 'update']);
    Route::delete('atmospheres/{atmosphere}', [AtmosphereController::class, 'destroy']);
    Route::post('atmospheres/{atmosphere}/invite', [AtmosphereController::class, 'invite']);
    Route::post('atmospheres/{atmosphere}/remove/{user}', [AtmosphereController::class, 'removeUser']);
    Route::post('atmospheres/{atmosphere}/questions', [AtmosphereController::class, 'generateQuestion']);
    Route::get('atmospheres/{atmosphere}/questions', [AtmosphereController::class, 'getQuestions']);
    Route::post('atmospheres/{atmosphere}/questions/{question}/answer', [AtmosphereController::class, 'answerQuestion']);
    Route::get('user/created-atmospheres', [AtmosphereController::class, 'getCreatedAtmospheres']);
});
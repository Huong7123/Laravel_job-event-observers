<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class,'store']);
Route::put('/user/{id}', [UserController::class,'update']);
<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [AuthController::class,"login"] );
Route::post('/auth/register', [AuthController::class,"register"] );
Route::get('/admin/users', [AuthController::class,"users"] );

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
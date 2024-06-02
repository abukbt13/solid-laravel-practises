<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [AuthController::class,"login"] );
Route::post('/auth/register', [AuthController::class,"register"] );


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Apply the 'auth:sanctum' middleware to a group of routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Define the route to get the list of users
    Route::get('/admin/users', [AuthController::class, 'users']);
});

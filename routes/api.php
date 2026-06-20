<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TrackingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Endpoint untuk aplikasi mobile melacak resi
Route::get('/tracking/{resi}', [TrackingController::class, 'track']);
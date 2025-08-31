<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get( '/posts', [PostController::class, 'index'] );

Route::get( '/posts/{post}', [PostController::class, 'show'] );

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

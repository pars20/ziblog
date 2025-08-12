<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::resource('posts', PostController::class)
    ->except(['index','show'])
    ->middleware('auth');
Route::prefix('posts')->name('posts.')->group(function(){
    Route::get('/', [PostController::class, 'index'] )->name('index');
    Route::get('/{post}', [PostController::class, 'show'] )->name('show');
});




Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

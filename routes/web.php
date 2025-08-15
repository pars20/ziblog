<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;


Route::resource('posts', PostController::class)
    ->except(['index','show'])
    ->middleware('auth');
Route::prefix('posts')->name('posts.')->group(function(){
    Route::get('/', [PostController::class, 'index'] )->name('index');
    Route::get('/{post}', [PostController::class, 'show'] )->name('show');
});

Route::post('/{post}/comments', [CommentController::class, 'store'] )
    ->name('posts.comments.store')
    ->middleware('auth');
    

Route::get('tag/{tag}', [ TagController::class, 'show' ])->name('tags.show');

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

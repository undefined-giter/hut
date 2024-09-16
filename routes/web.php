<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use Inertia\Inertia;

Route::get('/', function () { return Inertia::render('Welcome'); })->name('homepage');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

Route::get('/book', [BookingController::class, 'index'])->name('book');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit-picture', [ProfileController::class, 'editPicture'])->name('profile.edit-picture');
    Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', Admin::class])->name('admin.')->group(function () {
    Route::get('/list', [UserController::class, 'index'])->name('list');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('details');
    
    Route::delete('/user/{id}', [ProfileController::class, 'destroy'])->name('delete');
});

require __DIR__.'/auth.php';

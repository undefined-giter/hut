<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BookingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('homepage');

Route::get('/book', [BookingController::class, 'index'])->name('book');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', Admin::class])->name('admin.')->group(function () {
    Route::get('/list', [UserController::class, 'index'])->name('list');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('details');
});

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';

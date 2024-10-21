<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use Inertia\Inertia;

Route::get('/', function () { return Inertia::render('Welcome'); })->name('homepage');

Route::get('/gallerie', [GalleryController::class, 'index'])->name('gallery');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::middleware('auth')->group(function () {
    Route::get('/reserver', [ReservationController::class, 'index'])->name('book');
    Route::post('/book', [ReservationController::class, 'store']);
    
    Route::get('/book/{id}/edit', [ReservationController::class, 'edit'])->name('book.edit');
    Route::post('/book/{id}/update', [ReservationController::class, 'store'])->name('book.update');

    Route::delete('/book/{id}', [ReservationController::class, 'destroy'])->name('book.delete');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/edit-picture', [ProfileController::class, 'editPicture'])->name('profile.edit-picture');
    Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('user.delete');
});

Route::middleware(['auth', Admin::class])->name('admin.')->group(function () {
    Route::get('/list', [UserController::class, 'index'])->name('list');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('details');

    Route::resource('/options', OptionController::class)->except(['show']);
    Route::put('/options/{option}/toggle-availability', [OptionController::class, 'toggleAvailability'])->name('options.toggle-availability');
    Route::put('/options/{option}/toggle-preselected', [OptionController::class, 'togglePreselected'])->name('options.toggle-preselected');
    Route::put('/options/{option}/toggle-by-day-display', [OptionController::class, 'toggleByDayDisplay'])->name('options.toggle-by-day-display');
    Route::put('/options/{option}/toggle-by-day-preselected', [OptionController::class, 'toggleByDayPreselected'])->name('options.toggle-by-day-preselected');

    Route::get('/prices', [PriceController::class, 'getPrices'])->name('prices');
    Route::post('/prices/update', [PriceController::class, 'updatePrices'])->name('prices.update');
});

require __DIR__.'/auth.php';

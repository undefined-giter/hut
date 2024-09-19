<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use Inertia\Inertia;

Route::get('/', function () { return Inertia::render('Welcome'); })->name('homepage');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

Route::middleware('auth')->group(function () {
    Route::get('/book', [ReservationController::class, 'index'])->name('book');
    Route::post('/book', [ReservationController::class, 'store']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit-picture', [ProfileController::class, 'editPicture'])->name('profile.edit-picture');
    Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    
    Route::delete('/book/{id}', [ReservationController::class, 'destroy'])->name('reservation.delete');
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('user.delete');
});

Route::middleware(['auth', Admin::class])->name('admin.')->group(function () {
    Route::get('/list', [UserController::class, 'index'])->name('list');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('details');
});

require __DIR__.'/auth.php';
// ajouter reservation effectuées en auth profil et leur suppression each
// delete user doit supprimer ses reservations. Cascade : Prévenir annulation réservation pour l'utilisateur qui souhaite supprimer son compte
<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReservationController;

use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\SpecialDatePriceController;
use App\Http\Controllers\Admin\AdminCommentController;

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use Inertia\Inertia;


Route::get('/', function () {
    $adminPhone = config('admin.phone');
    return Inertia::render('Homepage/Welcome', [
        'adminPhoneHref' => $adminPhone,
        'adminPhone' => format_phone_number($adminPhone),
        'accountDeleted' => request()->query('account_deleted') === 'true',
    ]);
})->name('homepage');

Route::get('/gallerie', [GalleryController::class, 'index'])->name('gallery');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/reserver', [ReservationController::class, 'index'])->name('book');
    Route::post('/book', [ReservationController::class, 'store']);

    Route::post('/payement-avec-stripe', [StripeController::class, 'createSession'])->name('payment');
    
    Route::get('/book/{id}/edit', [ReservationController::class, 'edit'])->name('book.edit');
    Route::post('/book/{id}/update', [ReservationController::class, 'store'])->name('book.update');

    Route::delete('/book/{id}', [ReservationController::class, 'destroy'])->name('book.delete');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/get-phone', [ProfileController::class, 'fetchPhone']);
    Route::patch('/update-phone', [ProfileController::class, 'updatePhone']);

    Route::get('/profile/edit-picture', [ProfileController::class, 'editPicture'])->name('profile.edit-picture');
    Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('user.delete');

    Route::get('/specials-dates-prices', [SpecialDatePriceController::class, 'index'])->name('specials-dates-prices.index');
});

Route::middleware(['auth', Admin::class])->name('admin.')->group(function () {
    Route::get('/liste-utilisateurs', [UserController::class, 'index'])->name('list');
    Route::get('/utilisateur/{id}', [UserController::class, 'show'])->name('details');

    Route::get('/comments/{user}', [AdminCommentController::class, 'index'])->name('comments');
    Route::post('/comments', [AdminCommentController::class, 'store'])->name('comment.store');
    Route::put('/comments/{comment}', [AdminCommentController::class, 'update'])->name('comment.update');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comment.delete');

    Route::resource('/options', OptionController::class)->except(['show', 'create']);
    Route::get('/option/creer-nouvelle-option', [OptionController::class, 'create'])->name('options.create');
    Route::put('/options/{option}/toggle-availability', [OptionController::class, 'toggleAvailability'])->name('options.toggle-availability');
    Route::put('/options/{option}/toggle-preselected', [OptionController::class, 'togglePreselected'])->name('options.toggle-preselected');
    Route::put('/options/{option}/toggle-by-day-display', [OptionController::class, 'toggleByDayDisplay'])->name('options.toggle-by-day-display');
    Route::put('/options/{option}/toggle-by-day-preselected', [OptionController::class, 'toggleByDayPreselected'])->name('options.toggle-by-day-preselected');

    Route::get('/prix', [PriceController::class, 'getPrices'])->name('prices');
    Route::post('/prix', [PriceController::class, 'updatePrices'])->name('prices.update');

    Route::resource('/specials-dates-prices', SpecialDatePriceController::class)->except(['index']);    
});

require __DIR__.'/auth.php';

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Http\Controllers\ReservationController;
use App\Models\Admin\LimitesDates;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        $today = now()->startOfDay();
        $reservations = Reservation::where('end_date', '>', $today)->orderBy('start_date')->get();

        // Instancier ReservationController et appeler la méthode getCalendarColors
        $reservationController = new ReservationController();
        $calendarColors = $reservationController->getCalendarColors($reservations);
        $calendarColors['inner_date'] = array_merge($calendarColors['inner_date'], $calendarColors['switch_date']);

        $limitesDates = LimitesDates::first();

        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),

            'in_date' => $calendarColors['in_date'],
            'inner_date' => $calendarColors['inner_date'],
            'out_date' => $calendarColors['out_date'],

            'minDate' => $limitesDates->minDate,
            'maxDate' => $limitesDates->maxDate,
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $request->authenticate();
        $request->session()->regenerate();

        if (Auth::check()) {
            Auth::user()->update([
                'last_login' => now(),
            ]);
        }

        if (in_array(Auth::user()->role, ['admin', 'fake_admin'])) {
            session()->flash('success', ['Bienvenue Admin.']);
            return Inertia::location(route('admin.list'));
        }

        session()->flash('success', ['Vous pouvez à présent réserver votre bonheur.']);

        return Inertia::location(route('book'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservationController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();
        $reservations = Reservation::where('start_date', '>=', $today)->get();

        return Inertia::render('Book/index', [
            'reservations' => $reservations
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'nights' => 'required|integer|min:1',
        ]);
    
        Reservation::create([
            'user_id' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nights' => $request->nights,
            'status' => 'pending',
        ]);
    
        return redirect()->route('book')->with('success', ["Demande de réservation effectuée avec succès, à très bientôt !"]);
    }
}

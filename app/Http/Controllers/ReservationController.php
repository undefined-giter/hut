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
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'nights' => 'required|integer|min:1',
        ]);
    
        // Vérification des conflits en excluant la date de départ des réservations existantes
        $conflictingReservations = Reservation::where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->exists();
    
        if ($conflictingReservations) {
            return back()->with('error', ["Il y a déjà une réservation durant cette période.\nVeuillez choisir une autre période ou n'hésitez pas à nous appeler directement."]);
        }
    
        // Créer la réservation si aucun conflit
        Reservation::create([
            'user_id' => auth()->id(),
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'nights' => $validatedData['nights'],
            'status' => 'pending',
        ]);
    
        return redirect()->route('book')->with('success', ['Réservation effectuée avec succès']);
    }
}

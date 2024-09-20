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
        
        
        
        $conflictingReservations = Reservation::where('start_date', '<', $validatedData['end_date'])
        ->where('end_date', '>', $validatedData['start_date'])
        ->exists();
        
        if ($conflictingReservations) {
            return back()->with('error', ["Il y a déjà une réservation durant cette période.\nVeuillez choisir une autre période ou n'hésitez pas à nous appeler directement."]);
        }
        
        Reservation::create([
            'user_id' => auth()->id(),
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'nights' => $validatedData['nights'],
            'status' => 'pending',
        ]);
    
        return redirect()->route('gallery')->with('success', ['Réservation effectuée avec succès']);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $currentUser = auth()->user();
    
        if ($currentUser->role !== 'admin' && $currentUser->id !== $reservation->user_id) {
            return redirect()->route('book')->with('error', ['Vous n\'êtes pas autorisé à supprimer cette réservation.']);
        }
    
        $reservation->delete();
    
        return redirect()->route('book')->with('success', ['Réservation supprimée']);
    } 
}

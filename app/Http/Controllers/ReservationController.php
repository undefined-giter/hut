<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Option;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();
        $reservations = Reservation::where('end_date', '>', $today)->get();

        $options = Option::where('available', true)->get();
        return Inertia::render('Book/index', [
            'reservations' => $reservations,
            'options' => $options,
        ]);
    }

    public function store(Request $request, $reservationId = null)
    {
        $options = json_decode($request->input('options'), true);
        if (!is_array($options)) {
            return back()->with('error', ['Erreur dans les options sélectionnées.']);
        }
        $request->merge(['options' => $options]);

        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'nights' => 'required|integer|min:1',
            'options' => 'array',
            'options.*' => 'exists:options,id',
            'res_price' => 'required|numeric',
        ]);

        if($reservationId == null){
            $existingReservation = Reservation::where('user_id', auth()->id())
                ->where('start_date', '<', $validatedData['end_date'])
                ->where('end_date', '>', $validatedData['start_date'])
                ->first();
                
            if ($existingReservation) {
                return redirect()->route('profile.edit')
                ->with('error', ['Vous avez déjà une réservation durant cette période. Veuillez modifier votre réservation existante.']);
            }
        }
                
        $conflictingReservations = Reservation::where('user_id', '!=', auth()->id())
            ->where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->exists();

        if ($conflictingReservations) {
            return back()->with('error', ["Il y a déjà une réservation durant cette période. Veuillez choisir une autre date ou non contacter directement."]);
        }

        if ($reservationId) {
            $existingReservation = Reservation::where('user_id', auth()->id())
                ->where('id', $reservationId)
                ->first();

            if ($existingReservation) {
                if ($existingReservation->start_date == $validatedData['start_date'] && $existingReservation->end_date == $validatedData['end_date']) {
                    if (isset($validatedData['options'])) {
                        $existingReservation->options()->sync($validatedData['options']);

                        $existingReservation->update(['res_price' => $validatedData['res_price']]);
                    }

                    return redirect()->route('profile.edit')->with('success', ['Vos options ont bien été mises à jour']);
                } else {
                    $existingReservation->update([
                        'start_date' => $validatedData['start_date'],
                        'end_date' => $validatedData['end_date'],
                        'nights' => $validatedData['nights'],
                        'res_price' => $validatedData['res_price'],
                    ]);

                    if (isset($validatedData['options'])) {
                        $existingReservation->options()->sync($validatedData['options']);
                    }

                    return redirect()->route('profile.edit')->with('success', ['Les dates et options de votre réservation ont bien été mises à jour']);
                }
            }
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'nights' => $validatedData['nights'],
            'res_price' => $validatedData['res_price'],
            'status' => 'pending',
        ]);

        if (isset($validatedData['options'])) {
            $reservation->options()->sync($validatedData['options']);
        }

        return redirect()->route('profile.edit')->with('success', ['Réservation effectuée ! À très vite 🌞']);
    }


    public function edit($id)
    {
        $today = now()->startOfDay();
        $reservations = Reservation::where('end_date', '>', $today)->get();

        $options = Option::all();
        
        $reservationEdit = Reservation::with('options')->findOrFail($id);

        return Inertia::render('Book/index', [
            'reservations' => $reservations,
            'options' => $options,
            'reservationEdit' => $reservationEdit,
        ]);
    }    

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $currentUser = auth()->user();
    
        if ($currentUser->role !== 'admin' && $currentUser->id !== $reservation->user_id) {
            return redirect()->route('book')->with('error', ['Vous n\'êtes pas autorisé à supprimer cette réservation.']);
        }
    
        $reservation->delete();
    
        return redirect()->route('book')->with('success', ['Réservation annulée.']);
    } 
}

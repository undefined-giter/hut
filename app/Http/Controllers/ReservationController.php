<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Option;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private function getCalendarColors($reservations, $userId)
    {
        $in_date = [];
        $inner_date = [];
        $out_date = [];
        $switch_date = [];
        
        $user_in_date = [];
        $user_inner_date = [];
        $user_out_date = [];
        $user_switch_date = [];
        $user_switch_to_other = [];
        $other_switch_to_user = [];

        foreach ($reservations as $reservation) {
            $startDate = \Carbon\Carbon::parse($reservation->start_date)->toDateString();
            $endDate = \Carbon\Carbon::parse($reservation->end_date)->toDateString();

            if ($reservation->user_id === $userId) {
                // Cas où le même utilisateur a des réservations consécutives
                if (in_array($startDate, $user_out_date)) {
                    $user_switch_date[] = $startDate; // Green to purple to green for consecutive reservations
                    $user_out_date = array_diff($user_out_date, [$startDate]);
                } else {
                    $user_in_date[] = $startDate;
                }

                if (in_array($endDate, $user_in_date)) {
                    $user_switch_date[] = $endDate;
                    $user_in_date = array_diff($user_in_date, [$endDate]);
                } else {
                    $user_out_date[] = $endDate;
                }

                // Cas où l'utilisateur chevauche la réservation d'un autre utilisateur
                if (in_array($endDate, $in_date)) {
                    $user_switch_to_other[] = $endDate; // Green to red
                    $in_date = array_diff($in_date, [$endDate]);
                }

                if (in_array($startDate, $out_date)) {
                    $other_switch_to_user[] = $startDate; // Red to green
                    $out_date = array_diff($out_date, [$startDate]);
                }

                // Gestion des dates intermédiaires pour l'utilisateur
                $userCurrentDate = \Carbon\Carbon::parse($startDate)->addDay();
                while ($userCurrentDate->lt(\Carbon\Carbon::parse($endDate))) {
                    $user_inner_date[] = $userCurrentDate->toDateString();
                    $userCurrentDate->addDay();
                }
            } else {
                // Gestion des dates pour les autres utilisateurs
                if (in_array($startDate, $user_out_date)) {
                    $user_switch_to_other[] = $startDate; // Green to red
                    $user_out_date = array_diff($user_out_date, [$startDate]);
                } else {
                    $in_date[] = $startDate;
                }

                if (in_array($endDate, $user_in_date)) {
                    $other_switch_to_user[] = $endDate; // Red to green
                    $user_in_date = array_diff($user_in_date, [$endDate]);
                } else {
                    $out_date[] = $endDate;
                }

                $currentDate = \Carbon\Carbon::parse($startDate)->addDay();
                while ($currentDate->lt(\Carbon\Carbon::parse($endDate))) {
                    $inner_date[] = $currentDate->toDateString();
                    $currentDate->addDay();
                }
            }
        }

        return [
            'in_date' => $in_date,
            'inner_date' => $inner_date,
            'out_date' => $out_date,
            'switch_date' => $switch_date,
            'user_in_date' => $user_in_date,
            'user_inner_date' => $user_inner_date,
            'user_out_date' => $user_out_date,
            'user_switch_date' => $user_switch_date,
            'user_switch_to_other' => $user_switch_to_other,
            'other_switch_to_user' => $other_switch_to_user,
        ];
    }


    public function index()
    {
        $today = now()->startOfDay();
        $reservations = Reservation::where('end_date', '>', $today)->orderBy('start_date')->get();
        $userId = auth()->id();

        $calendarColors = $this->getCalendarColors($reservations, $userId);

        $options = Option::where('available', true)->get();
        
        return Inertia::render('Book/index', [
            'reservations' => $reservations,
            'options' => $options,
            
            'in_date' => $calendarColors['in_date'],
            'inner_date' => $calendarColors['inner_date'],
            'out_date' => $calendarColors['out_date'],
            'switch_date' => $calendarColors['switch_date'],
            
            'user_in_date' => $calendarColors['user_in_date'],
            'user_inner_date' => $calendarColors['user_inner_date'],
            'user_out_date' => $calendarColors['user_out_date'],
            'user_switch_date' => $calendarColors['user_switch_date'],
            'user_switch_to_other' => $calendarColors['user_switch_to_other'],
            'other_switch_to_user' => $calendarColors['other_switch_to_user'],
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

        $userId = auth()->id();
        $calendarColors = $this->getCalendarColors($reservations, $userId);

        $options = Option::all();
        
        $reservationEdit = Reservation::with('options')->findOrFail($id);

        $arrivalDate = $reservationEdit->start_date;
        $showMonth = $showMonth = date('Y-m-01', strtotime($arrivalDate));
        
        return Inertia::render('Book/index', [
            'reservations' => $reservations,
            'options' => $options,
            'reservationEdit' => $reservationEdit,
            'showMonthEdit' => $showMonth,

            'in_date' => $calendarColors['in_date'],
            'inner_date' => $calendarColors['inner_date'],
            'out_date' => $calendarColors['out_date'],
            'switch_date' => $calendarColors['switch_date'],
            
            'user_in_date' => $calendarColors['user_in_date'],
            'user_inner_date' => $calendarColors['user_inner_date'],
            'user_out_date' => $calendarColors['user_out_date'],
            'user_switch_date' => $calendarColors['user_switch_date'],
            'user_switch_to_other' => $calendarColors['user_switch_to_other'],
            'other_switch_to_user' => $calendarColors['other_switch_to_user'],
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

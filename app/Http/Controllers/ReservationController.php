<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Option;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    private function getCalendarColors($reservations, $resId = null)
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

        $edit_reservation_dates = [];

        foreach ($reservations as $reservation) {
            $startDate = \Carbon\Carbon::parse($reservation->start_date)->toDateString();
            $endDate = \Carbon\Carbon::parse($reservation->end_date)->toDateString();

            if ($reservation->user_id === auth()->id()) {

                if ($reservation->id == $resId) {
                    $currentDate = \Carbon\Carbon::parse($startDate);
                    while ($currentDate->lte(\Carbon\Carbon::parse($endDate))) {
                        $edit_reservation_dates[] = $currentDate->toDateString();
                        $currentDate->addDay();
                    }
                }

                if (in_array($startDate, $user_out_date)) {
                    $user_switch_date[] = $startDate;
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
        
                if (in_array($endDate, $in_date)) {
                    $user_switch_to_other[] = $endDate;
                    $in_date = array_diff($in_date, [$endDate]);
                    $user_out_date = array_diff($user_out_date, [$endDate]);
                }
        
                if (in_array($startDate, $user_in_date) && in_array($startDate, $out_date)) {
                    $other_switch_to_user[] = $startDate;
                    $user_in_date = array_diff($user_in_date, [$startDate]);
                }
        
                $userCurrentDate = \Carbon\Carbon::parse($startDate)->addDay();
                while ($userCurrentDate->lt(\Carbon\Carbon::parse($endDate))) {
                    $user_inner_date[] = $userCurrentDate->toDateString();
                    $userCurrentDate->addDay();
                }
            } else {
                if (in_array($startDate, $out_date) && in_array($endDate, $in_date)) {
                    $switch_date[] = $startDate;
                    $out_date = array_diff($out_date, [$startDate]);
                } elseif (in_array($startDate, $out_date)) {
                    $switch_date[] = $startDate;
                    $out_date = array_diff($out_date, [$startDate]);
                } else {
                    $in_date[] = $startDate;
                }
        
                if (in_array($startDate, $user_out_date)) {
                    $user_switch_to_other[] = $startDate;
                    $user_out_date = array_diff($user_out_date, [$startDate]);
                }
        
                if (in_array($endDate, $user_in_date)) {
                    $other_switch_to_user[] = $endDate;
                    $user_in_date = array_diff($user_in_date, [$endDate]);
                } elseif ($endDate == $startDate) {
                    $other_switch_to_user[] = $startDate;
                    $out_date = array_diff($out_date, [$startDate]);
                } else {
                    $out_date[] = $endDate;
                }

                if (in_array($endDate, $in_date) ) {
                    $switch_date[] = $endDate;
                    $out_date = array_diff($out_date, [$endDate]);
                    $in_date = array_diff($in_date, [$endDate]);
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
            'edit_reservation_dates' => $edit_reservation_dates,            
        ];
    }


    public function index()
    {
        $today = now()->startOfDay();
        $reservations = Reservation::where('end_date', '>', $today)->orderBy('start_date')->get();

        $calendarColors = $this->getCalendarColors($reservations);

        $options = Option::where('available', true)->get();

        $pricePerNight = DB::table('prices')->where('key', 'price_per_night')->value('value');
        $pricePerNightFor2AndMoreNights = DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->value('value');
        
        return Inertia::render('Book/index', [
            'reservations' => $reservations,
            'options' => $options,
            'PRICE_PER_NIGHT' => $pricePerNight,
            'PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS' => $pricePerNightFor2AndMoreNights,
            
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
            'res_comment' => 'nullable|max:510',
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
                ->with('error', ['Vous avez déjà une réservation durant cette période.<br><span style="color: #ff9a34;">Veuillez modifier votre réservation existante.</span>']);
            }
        }
                
        $userId = auth()->user()->role === 'admin' && $reservationId ? Reservation::find($reservationId)->user_id : auth()->id();
        
        $conflictingReservations = Reservation::where('user_id', '!=', $userId)
            ->where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->exists();

        if ($conflictingReservations) {
            return back()->with('error', ["Il y a déjà une réservation durant cette période.<br><span style='color: #fc8003;'>Veuillez choisir une autre date ou nous contacter directement.</span>"]);
        }

        if ($reservationId) {
            $existingReservation = Reservation::where('user_id', $userId)
                ->where('id', $reservationId)
                ->first();

            if ($existingReservation) {
                if ($existingReservation->start_date == $validatedData['start_date'] && $existingReservation->end_date == $validatedData['end_date']) {
                    if (isset($validatedData['options'])) {
                        $existingReservation->options()->sync($validatedData['options']);

                        $existingReservation->update([
                            'res_price' => $validatedData['res_price'],
                            'res_comment' => $validatedData['res_comment'],
                        ]);
                    }

                    if (auth()->user()->role === 'admin') {
                        return redirect()->route('admin.list')->with('success', ['Les options de la réservation ont bien été mises à jour']);
                    }

                    return redirect()->route('profile.edit')->with('success', ['Vos options ont bien été mises à jour']);
                } else {
                    $existingReservation->update([
                        'start_date' => $validatedData['start_date'],
                        'end_date' => $validatedData['end_date'],
                        'nights' => $validatedData['nights'],
                        'res_price' => $validatedData['res_price'],
                        'res_comment' => $validatedData['res_comment'],
                    ]);

                    if (isset($validatedData['options'])) {
                        $existingReservation->options()->sync($validatedData['options']);
                    }

                    if (auth()->user()->role === 'admin') {
                        return redirect()->route('admin.list')->with('success', ['Les dates et options de la réservation ont bien été mises à jour']);
                    }

                    return redirect()->route('profile.edit')->with('success', ['Les dates et options de votre réservation ont bien été mises à jour']);
                }
            }
        }

        $reservation = Reservation::create([
            'user_id' => $userId,
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'nights' => $validatedData['nights'],
            'res_comment' => $validatedData['res_comment'],
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

        $pricePerNight = DB::table('prices')->where('key', 'price_per_night')->value('value');
        $pricePerNightFor2AndMoreNights = DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->value('value');

        $calendarColors = $this->getCalendarColors($reservations, $id);

        $options = Option::all();
        
        $reservationEdit = Reservation::with('options')->findOrFail($id);

        $arrivalDate = $reservationEdit->start_date;
        $showMonth = $showMonth = date('Y-m-01', strtotime($arrivalDate));
        
        return Inertia::render('Book/index', [
            'reservations' => $reservations,
            'options' => $options,
            'reservationEdit' => $reservationEdit,
            'showMonthEdit' => $showMonth,
            'PRICE_PER_NIGHT' => $pricePerNight,
            'PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS' => $pricePerNightFor2AndMoreNights,
        
            'in_date' => array_values($calendarColors['in_date']),
            'inner_date' => array_values($calendarColors['inner_date']),
            'out_date' => array_values($calendarColors['out_date']),
            'switch_date' => array_values($calendarColors['switch_date']),
        
            'user_in_date' => array_values($calendarColors['user_in_date']),
            'user_inner_date' => array_values($calendarColors['user_inner_date']),
            'user_out_date' => array_values($calendarColors['user_out_date']),
            'user_switch_date' => array_values($calendarColors['user_switch_date']),
            'user_switch_to_other' => array_values($calendarColors['user_switch_to_other']),
            'other_switch_to_user' => array_values($calendarColors['other_switch_to_user']),

            'edit_reservation_dates' => array_values($calendarColors['edit_reservation_dates']),
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

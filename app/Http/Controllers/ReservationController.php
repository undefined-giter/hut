<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Option;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationMail;
use App\Mail\ReservationDeletedMail;

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
        $user = Auth::user();

        if($user->role === 'fake_admin'){
            return redirect()->route('profile')->with('error', ['Vous n\'êtes pas autorisé à effectuer de réservation en tant que fake_admin, ni à la modifiée, ni à modifier celles des autres à leur place.<br>
                <span style="color:gray">Si vous réservez avec un autre profil sans réèlle intention de réserver le gîte, merci de SUPPRIMER VOS RÉSERVATIONS IMMEDIATEMENT après vos tests terminés svp.<br>Merci.<span>']);
        }

        $optionsJson = $request->input('options');
        $optionsData = json_decode($optionsJson, true);
    
        if (!is_array($optionsData)) { $optionsData = []; }
    
        $optionIds = collect($optionsData)->pluck('id')->toArray();
        $selectedOptions = Option::whereIn('id', $optionIds)->get();

        $optionsWithByDay = $selectedOptions->mapWithKeys(function ($option) use ($optionsData) {
            $byDay = collect($optionsData)->firstWhere('id', $option->id)['by_day'] ?? false;
            return [
                $option->id => [
                    'by_day' => $byDay,
                ]
            ];
        });

        $request->merge(['options' => $optionsData]);

        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'nights' => 'required|integer|min:1',
            'res_comment' => 'nullable|max:510',
            'res_price' => 'required|numeric',
            'options' => 'nullable|array',
            'options.*.id' => 'nullable|exists:options,id',
            'options.*.by_day' => 'nullable|boolean',
        ]);
        
        if($reservationId == null){
            $existingReservation = Reservation::where('user_id', $user->id)
                ->where('start_date', '<', $validatedData['end_date'])
                ->where('end_date', '>', $validatedData['start_date'])
                ->first();
                
            if ($existingReservation) {
                return redirect()->route('profile')
                    ->with('error', ['Vous avez déjà une réservation durant cette période.<br><span style="color: #ff9a34;">Veuillez modifier votre réservation existante.</span>']);
            }
        }
                
        $userId = $user->role === 'admin' && $reservationId ? Reservation::find($reservationId)->user_id : $user->id;
        
        $conflictingReservations = Reservation::where('user_id', '!=', $userId)
            ->where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->exists();

        if ($conflictingReservations) {
            return back()->with('error', ["Il y a déjà une réservation durant cette période.<br><span style='color: #fc8003;'>Veuillez choisir une autre date ou nous contacter directement.</span>"]);
        }

        if ($reservationId) {
            $existingReservation = Reservation::findOrFail($reservationId);

            if ($existingReservation) {
                // Séparée au cas ou des réservtions été passées sans enregistrer le prix, ce qui n'aura plus réèlement de sens en prod et créé qu'une requêtes supplementaire mais assure la maj du prix même si aucun n'était enregistré
                if (is_null($existingReservation->res_price)) {
                    $existingReservation->update(['res_price' => $validatedData['res_price']]);
                }

                if ($existingReservation->start_date == $validatedData['start_date'] && $existingReservation->end_date == $validatedData['end_date']) {
                    if (!empty($optionsWithByDay)) {
                        $existingReservation->options()->sync($optionsWithByDay);

                        $existingReservation->update([
                            'res_comment' => $validatedData['res_comment'],
                            'res_price' => $validatedData['res_price'],
                        ]);

                        $selectedOptions = $existingReservation->options()->get();
        
                        Mail::to('leo.ripert@gmail.com')->send(new ReservationMail(
                            $existingReservation,
                            $user->name,
                            $user->name2 ?? null,
                            $user->phone ?? null,
                            $user->email,
                            $userId,
                            'updated_options',
                            $selectedOptions,
                            true
                        ));
                        Mail::to($user->email)->send(new ReservationMail(
                            $existingReservation,
                            $user->name,
                            null,
                            null,
                            null,
                            null,
                            'updated_options',
                            $selectedOptions,
                            false
                        ));
                    }

                    return $user->role === 'admin' ?
                        redirect()->route('admin.list')->with('success', ['Les options de la réservation ont bien été mises à jour']) :
                        redirect()->route('profile')->with('success', ['Vos options ont bien été mises à jour']);
                
                    } else {
                    $existingReservation->update([
                        'start_date' => $validatedData['start_date'],
                        'end_date' => $validatedData['end_date'],
                        'nights' => $validatedData['nights'],
                        'res_comment' => $validatedData['res_comment'],
                        'res_price' => $validatedData['res_price'],
                    ]);

                    if (!empty($optionsWithByDay)) {
                        $existingReservation->options()->sync($optionsWithByDay);
                    }

                    $selectedOptions = $existingReservation->options()->get();

                    Mail::to('leo.ripert@gmail.com')->send(new ReservationMail(
                        $existingReservation,
                        $user->name,
                        $user->name2 ?? null,
                        $user->phone ?? null,
                        $user->email,
                        $userId,
                        'updated',
                        $selectedOptions,
                        true
                    ));
                    Mail::to($user->email)->send(new ReservationMail(
                        $existingReservation,
                        $user->name,
                        null,
                        null,
                        null,
                        null,
                        'updated',
                        $selectedOptions,
                        false
                    ));

                    return $user->role === 'admin' ?
                        redirect()->route('admin.list')->with('success', ['Les dates et options de la réservation ont bien été mises à jour']) :
                        redirect()->route('profile')->with('success', ['Les dates et options de votre réservation ont bien été mises à jour']);
                }
            }
        }

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'nights' => $validatedData['nights'],
            'res_comment' => $validatedData['res_comment'],
            'res_price' => $validatedData['res_price'],
            'status' => 'pending',
        ]);

        $reservation->options()->sync($optionsWithByDay);

        $selectedOptions = $reservation->options()->get();

        $reservation->options()->sync($optionsWithByDay);
        
        Mail::to('leo.ripert@gmail.com')->send(new ReservationMail(
            $reservation,
            $user->name,
            $user->name2 ?? null,
            $user->phone ?? null,
            $user->email,
            $user->id,
            'created',
            $selectedOptions,
            true
        ));
        Mail::to($user->email)->send(new ReservationMail(
            $reservation,
            $user->name,
            null,
            null,
            null,
            null,
            'created',
            $selectedOptions,
            false
        ));

        return redirect()->route('profile')->with('success', ['Réservation effectuée ! À très vite 🌞']);
    }

    public function edit($id)
    {
        $today = now()->startOfDay();
        $reservations = Reservation::where('end_date', '>', $today)->get();

        $pricePerNight = DB::table('prices')->where('key', 'price_per_night')->value('value');
        $pricePerNightFor2AndMoreNights = DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->value('value');

        $calendarColors = $this->getCalendarColors($reservations, $id);

        $reservationEdit = Reservation::with(['options' => function ($query) {
            $query->select('options.*', 'option_reservation.by_day');
        }])->findOrFail($id);

        $arrivalDate = $reservationEdit->start_date;
        $showMonth = $showMonth = date('Y-m-01', strtotime($arrivalDate));
        
        return Inertia::render('Book/index', [
            'reservations' => $reservations,
            'options' => Option::all(),
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

        if ($currentUser->role === 'fake_admin') {
            return redirect()->route('book')->with('error', ['En tant que fake_admin, vous n\'êtes autorisé à supprimer aucune réservation.']);
        }
        
        if ($currentUser->role !== 'admin' && $currentUser->id !== $reservation->user_id) {
            return redirect()->route('book')->with('error', ['Vous n\'êtes pas autorisé à supprimer cette réservation.']);
        }
        
        $reservation->delete();
        
        $user = $currentUser->role === 'admin' ? $reservation->user : $currentUser;
        
        Mail::to('leo.ripert@gmail.com')->send(new ReservationDeletedMail(
            $reservation,
            $user->name,
            $user->name2 ?? null,
            $user->email,
            $user->phone ?? null,
            true
        ));
    
        Mail::to($user->email)->send(new ReservationDeletedMail(
            $reservation,
            $user->name,
            null,
            null,
            null,
            false
        ));
    
        return redirect()->route('book')->with('success', ['Votre réservation a bien été annulée.<br>N\'hésitez pas à revenir à l\'avenir !']);
    }
}

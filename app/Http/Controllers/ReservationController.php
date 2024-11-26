<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Admin\Option;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationMail;
use App\Mail\ReservationDeletedMail;
use App\Http\Requests\ReservationRequest;
use Carbon\Carbon;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Services\PriceCalculatorService;

class ReservationController extends Controller
{
    public function getCalendarColors($reservations, $resId = null): array
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
            $startDate = Carbon::parse($reservation->start_date)->toDateString();
            $endDate = Carbon::parse($reservation->end_date)->toDateString();

            if ($reservation->user_id === auth()->id()) {

                if ($reservation->id == $resId) {
                    $currentDate = Carbon::parse($startDate);
                    while ($currentDate->lte(Carbon::parse($endDate))) {
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
        
                $userCurrentDate = Carbon::parse($startDate)->addDay();
                while ($userCurrentDate->lt(Carbon::parse($endDate))) {
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

                if (in_array($endDate, $in_date)) {
                    $switch_date[] = $endDate;
                    $out_date = array_diff($out_date, [$endDate]);
                    $in_date = array_diff($in_date, [$endDate]);
                }
        
                $currentDate = Carbon::parse($startDate)->addDay();
                while ($currentDate->lt(Carbon::parse($endDate))) {
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


    public function index(): Response
    {
        $today = Carbon::now()->startOfDay();
        $reservations = Reservation::where('end_date', '>', $today)->orderBy('start_date')->get();

        $calendarColors = $this->getCalendarColors($reservations);

        $options = Option::where('available', true)->get();

        $pricePerNight = DB::table('prices')->where('key', 'price_per_night')->value('value');
        $pricePerNightFor2AndMoreNights = DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->value('value');
        $percentReducedWeek = DB::table('prices')->where('key', 'percent_reduced_week')->value('value');

        $specialDatesPricesArray = DB::table('specials_dates_prices')->where('spe_date', '>=', Carbon::now())
            ->select('spe_date', 'spe_price')
            ->orderBy('spe_date', 'asc')
            ->get();


        return Inertia::render('Book/index', [
            'reservations' => $reservations,
            'options' => $options,
            'PRICE_PER_NIGHT' => $pricePerNight,
            'PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS' => $pricePerNightFor2AndMoreNights,
            'PERCENT_REDUCED_WEEK' => $percentReducedWeek,
            'specialDatesPricesArray' => $specialDatesPricesArray,
            
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


    public function store(ReservationRequest $request, $reservationId = null): RedirectResponse
    {
        $user = Auth::user();
    
        if ($user->role === 'fake_admin') {
            return redirect()->route('profile')->with('error', ['Vous n\'êtes pas autorisé à effectuer de réservation en tant que fake_admin, ni à la modifier, ni à modifier celles des autres.']);
        }
    
        $validatedData = $request->validated();
    
        if ($reservationId == null) {
            $existingReservation = Reservation::where('user_id', $user->id)
                ->where('start_date', '<', $validatedData['end_date'])
                ->where('end_date', '>', $validatedData['start_date'])
                ->first();
    
            if ($existingReservation) {
                return redirect()->route('profile')->with('error', ['Vous avez déjà une réservation durant cette période.<br>Vous pouvez la modifiée en le retrouvant sur cette page.']);
            }
        }
    
        $userId = $user->role === 'admin' && $reservationId ? Reservation::find($reservationId)->user_id : $user->id;
        $conflictingReservations = Reservation::where('user_id', '!=', $userId)
            ->where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->exists();
    
        if ($conflictingReservations) {
            return back()->with('error', ["Il y a déjà une réservation durant cette période."]);
        }

        $optionIds = collect($validatedData['options'])->pluck('id')->toArray();
        $validatedOptions = collect($validatedData['options']);
        $selectedOptions = Option::whereIn('id', $optionIds)->get()->map(function ($option) use ($validatedOptions) {
            $option->by_day = $validatedOptions->firstWhere('id', $option->id)['by_day'] ?? false;
            return $option;
        });

        $optionsForSync = $selectedOptions->mapWithKeys(function ($option) {
            return [ $option->id => [ 'by_day' => $option->by_day ] ];
        })->toArray();

        $priceCalculator = new PriceCalculatorService();
        $calculatedPrice = $priceCalculator->calculatePrice($validatedData['start_date'], $validatedData['end_date'], $selectedOptions->toArray());
        $res_price = $calculatedPrice['res_price'];
        $nbOfNights = $calculatedPrice['nb_of_nights'];
    

        if ($reservationId) {
            $existingReservation = Reservation::findOrFail($reservationId);
    
            if ($existingReservation) {
                $isDateChange = ($existingReservation->start_date != $validatedData['start_date'] || $existingReservation->end_date != $validatedData['end_date']);
    
                $existingReservation->update([
                    'start_date' => $validatedData['start_date'],
                    'end_date' => $validatedData['end_date'],
                    'nights' => $nbOfNights,
                    'res_comment' => $validatedData['res_comment'],
                    'res_price' => $res_price,
                ]);
    
                $existingReservation->options()->sync($optionsForSync);
    
                $selectedOptions = $existingReservation->options()->get();
    
                $action = $isDateChange ? 'updated' : 'updated_options';
    
                $this->sendReservationEmails($existingReservation, $user, $selectedOptions, $action);
    
                $message = $isDateChange
                    ? 'Les dates et options de la réservation ont bien été mises à jour'
                    : 'Les options de la réservation ont bien été mises à jour';
    
                return $user->role === 'admin'
                    ? redirect()->route('admin.list')->with('success', [$message])
                    : redirect()->route('profile')->with('success', [$message]);
            }
        }
        
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'nights' => $nbOfNights,
            'res_comment' => $validatedData['res_comment'],
            'res_price' => $res_price,
            'status' => 'pending',
        ]);
    
        $reservation->options()->sync($optionsForSync);

        $this->sendReservationEmails($reservation, $user, $reservation->options()->get(), 'created');
    
        return redirect()->route('profile')->with('success', ['Réservation effectuée ! À très vite 🌞']);
    }

    /**
     * Send res mail // only for create and update (store method), not for destroy method
     */
    private function sendReservationEmails($reservation, $user, $selectedOptions, string $action): void
    {
        Mail::send(new ReservationMail(
            $reservation,
            $user->name,
            $user->name2 ?? null,
            $user->phone ?? null,
            $user->email,
            $user->id,
            $action,
            $selectedOptions,
            true
        ));
    
        Mail::to($user->email)->send(new ReservationMail(
            $reservation,
            $user->name,
            null,
            null,
            $user->email,
            null,
            $action,
            $selectedOptions,
            false
        ));
    }    


    public function edit($id): Response
    {
        $today = Carbon::now()->startOfDay();
        $reservations = Reservation::where('end_date', '>', $today)->get();

        $pricePerNight = DB::table('prices')->where('key', 'price_per_night')->value('value');
        $pricePerNightFor2AndMoreNights = DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->value('value');
        $percent_reduced_week = DB::table('prices')->where('key', 'percent_reduced_week')->value('value');

        $calendarColors = $this->getCalendarColors($reservations, $id);

        $reservationEdit = Reservation::with(['options' => function ($query) {
            $query->select('options.*', 'option_reservation.by_day');
        }])->findOrFail($id);

        $arrivalDate = $reservationEdit->start_date;
        $showMonth = date('Y-m-01', strtotime($arrivalDate));
        
        return Inertia::render('Book/index', [
            'reservations' => $reservations,
            'options' => Option::all(),
            'reservationEdit' => $reservationEdit,
            'showMonthEdit' => $showMonth,
            'PRICE_PER_NIGHT' => $pricePerNight,
            'PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS' => $pricePerNightFor2AndMoreNights,
            'PERCENT_REDUCED_WEEK' => $percent_reduced_week,
        
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
    

    public function destroy($id): RedirectResponse
    {
        $reservation = Reservation::findOrFail($id);
    
        $currentUser = auth()->user();
    
        if ($currentUser->role === 'fake_admin') {
            return redirect()->route('book')->with('error', ['En tant que fake_admin, vous n\'êtes pas autorisé à supprimer de réservations.']);
        }
    
        if ($currentUser->role !== 'admin' && $currentUser->id !== $reservation->user_id) {
            return redirect()->route('book')->with('error', ['Vous n\'êtes pas autorisé à supprimer cette réservation.']);
        }
    
        $reservation->delete();
    
        $user = $currentUser->role === 'admin' ? $reservation->user : $currentUser;
    
        Mail::send(new ReservationDeletedMail(
            $reservation,
            $user->name,
            $user->name2 ?? null,
            $user->email,
            $user->phone ?? null,
            $user->id,
            true
        ));
    
        Mail::to($user->email)->send(new ReservationDeletedMail(
            $reservation,
            $user->name,
            null,
            $user->email,
            null,
            null,
            false
        ));

        return redirect()->route('book')->with('success', ['Votre réservation a bien été annulée.<br>N\'hésitez pas à revenir à l\'avenir !']);
    }    
}

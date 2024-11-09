<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(): Response
    {
        $paginateLength = 15;
        $users = User::latest()->paginate($paginateLength);
    
        // Calculate the cut-off date -> all reservations CREATED within the last 12 months
        $twelveMonthsAgo = Carbon::now()->subMonths(12);
    
        // Total reservations and total money spent
        $reservations = Reservation::where('created_at', '>=', $twelveMonthsAgo)->get();
    
        // Calculate the average total basket (TTC): total money spent divided by the number of reservations
        $totalSpent = $reservations->sum('res_price'); // Sum of reservation prices
        $totalReservations = $reservations->count(); // Number of reservations
        $averageTtcBasket = $totalReservations > 0 ? round($totalSpent / $totalReservations, 2) : 'Indisponible';
    
        // Calculate the average number of nights reserved: total number of nights reserved divided by the number of reservations
        $totalNightsReserved = $reservations->sum('nights'); // Sum of nights reserved
        $averageDaysReserved = $totalReservations > 0 ? round($totalNightsReserved / $totalReservations, 2) : 'Indisponible';
    
        // Calculate average options per reservation in euros
        $averageOptionBasket = DB::table('option_reservation')
            ->join('options', 'option_reservation.option_id', '=', 'options.id')
            ->join('reservations', 'option_reservation.reservation_id', '=', 'reservations.id')
            ->where('reservations.created_at', '>=', $twelveMonthsAgo)
            ->selectRaw('ROUND(AVG(options.price), 2) as avg_options')
            ->first()
            ->avg_options ?? 'Indisponible';

        if (is_numeric($averageOptionBasket)) {
            $averageOptionBasket = floatval($averageOptionBasket);
        }
    
        // fetch the total or reservations last 12 months
        $averageReservationsPerMonth = $totalReservations > 0 
            ? round($totalReservations / 12, 2) 
            : 'Indisponible';
    
        return Inertia::render('Admin/Index', [
            'users' => $users,
            'averageTtcBasket' => $averageTtcBasket,
            'averageOptionBasket' => $averageOptionBasket,
            'averageDaysReserved' => $averageDaysReserved,
            'averageReservationsPerMonth' => round($averageReservationsPerMonth, 2),
            'paginateLength' => $paginateLength,
        ]);
    }

    public function show($id): Response
    {
        $user = User::with(['reservations.options', 'adminComments'])->findOrFail($id);
        $connected_user_id = auth()->id();
        
        return Inertia::render('Admin/Details', [
            'user' => $user,
            'reservations' => $user->reservations,
            'connected_user_id' => $connected_user_id,
        ]);
    }    

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.list')->with('success', ['Utilisateur supprimé.']);
    }
}

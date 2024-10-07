<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
    
        // Calculer la date limite
        $twelveMonthsAgo = now()->subMonths(12);
    
        // Total des réservations et total d'argent dépensé
        $reservations = Reservation::where('created_at', '>=', $twelveMonthsAgo)->get();
    
        // Calculer le panier TTC : total d'argent dépensé divisé par le nombre de réservations
        $totalSpent = $reservations->sum('res_price'); // Somme des prix des réservations
        $totalReservations = $reservations->count(); // Nombre de réservations
        $averageTtcBasket = $totalReservations > 0 ? round($totalSpent / $totalReservations, 2) : 'Indisponible';
    
        // Calculer le nombre de nuits réservées moyen : nombre total de nuits réservées divisé par le nombre de réservations
        $totalNightsReserved = $reservations->sum('nights'); // Somme des nuits réservées
        $averageDaysReserved = $totalReservations > 0 ? round($totalNightsReserved / $totalReservations, 2) : 'Indisponible';
    
        // Calculer la moyenne des options prises par réservation
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
    
        // Récupérer le nombre total de réservations dans les 12 derniers mois
        $averageReservationsPerMonth = $totalReservations > 0 
        ? round($totalReservations / 12, 2) 
        : 'Indisponible';
    
        return Inertia::render('Admin/Index', [
            'users' => $users,
            'averageTtcBasket' => $averageTtcBasket,
            'averageOptionBasket' => $averageOptionBasket,
            'averageDaysReserved' => $averageDaysReserved,
            'averageReservationsPerMonth' => round($averageReservationsPerMonth, 2),
        ]);
    }
    

    public function show($id)
    {
        $user = User::with('reservations.options')->findOrFail($id);
    
        return Inertia::render('Admin/Details', [
            'user' => $user,
            'reservations' => $user->reservations,
        ]);
    }    

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.list')->with('success', ['Utilisateur supprimé.']);
    }
}

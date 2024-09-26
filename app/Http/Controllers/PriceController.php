<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PriceController extends Controller
{
    public function getPrices()
    {
        $pricePerNight = DB::table('prices')->where('key', 'price_per_night')->value('value');
        $pricePerNightFor2AndMoreNights = DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->value('value');

        return Inertia::render('Admin/ChangePrices', [
            'price_per_night' => $pricePerNight,
            'price_per_night_for_2_and_more_nights' => $pricePerNightFor2AndMoreNights,
        ]);
    }

    public function updatePrices(Request $request)
    {
        // Valider les entrées
        $request->validate([
            'price_per_night' => 'required|integer|min:0',
            'price_per_night_for_2_and_more_nights' => 'required|integer|min:0',
        ]);
    
        DB::table('prices')->where('key', 'price_per_night')->update(['value' => $request->input('price_per_night')]);
        DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->update(['value' => $request->input('price_per_night_for_2_and_more_nights')]);
    
        return redirect()->route('admin.options.index')->with('success', ['Les prix ont été mis à jour']);
    }
}

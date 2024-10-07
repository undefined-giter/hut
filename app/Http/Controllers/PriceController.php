<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PriceController extends Controller
{
    public function getPrices($return_json = false)
    {
        $pricePerNight = DB::table('prices')->where('key', 'price_per_night')->value('value');
        $pricePerNightFor2AndMoreNights = DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->value('value');

        if ($return_json) {
            return response()->json([
                'PRICE_PER_NIGHT' => $pricePerNight,
                'PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS' => $pricePerNightFor2AndMoreNights,
            ]);
        }

        return Inertia::render('Admin/ChangePrices', [
            'price_per_night' => $pricePerNight,
            'price_per_night_for_2_and_more_nights' => $pricePerNightFor2AndMoreNights,
        ]);
    }

    public function updatePrices(Request $request)
    {
        $request->validate([
            'price_per_night' => 'required|integer|min:0',
            'price_per_night_for_2_and_more_nights' => 'required|integer|min:0',
        ]);
    
        $pricePerNightExists = DB::table('prices')->where('key', 'price_per_night')->exists();
        if ($pricePerNightExists) {
            DB::table('prices')->where('key', 'price_per_night')->update(['value' => $request->input('price_per_night')]);
        } else {
            DB::table('prices')->insert(['key' => 'price_per_night', 'value' => $request->input('price_per_night')]);
        }
    
        $pricePerNightFor2Exists = DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->exists();
        if ($pricePerNightFor2Exists) {
            DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->update(['value' => $request->input('price_per_night_for_2_and_more_nights')]);
        } else {
            DB::table('prices')->insert(['key' => 'price_per_night_for_2_and_more_nights', 'value' => $request->input('price_per_night_for_2_and_more_nights')]);
        }
    
        return redirect()->route('admin.options.index')->with('success', ['Les prix ont été mis à jour']);
    }
}

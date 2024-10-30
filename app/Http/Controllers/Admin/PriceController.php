<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PriceRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class PriceController extends Controller
{
    public function getPrices(): Response
    {
        $pricePerNight = DB::table('prices')->where('key', 'price_per_night')->value('value');
        $pricePerNightFor2AndMoreNights = DB::table('prices')->where('key', 'price_per_night_for_2_and_more_nights')->value('value');

        return Inertia::render('Admin/ChangePrices', [
            'price_per_night' => $pricePerNight,
            'price_per_night_for_2_and_more_nights' => $pricePerNightFor2AndMoreNights,
        ]);
    }

    public function updatePrices(PriceRequest $request): RedirectResponse
    {
        if (auth()->user()->role === 'fake_admin') {
            return redirect()->route('admin.prices')->with('error', ["En tant que fake_admin, vous n'êtes pas autorisé à changer les prix des réservations."]);
        }

        $validated = $request->validated();
    
        DB::table('prices')->updateOrInsert(
            ['key' => 'price_per_night'],
            ['value' => $validated['price_per_night']]
        );
    
        DB::table('prices')->updateOrInsert(
            ['key' => 'price_per_night_for_2_and_more_nights'],
            ['value' => $validated['price_per_night_for_2_and_more_nights']]
        );
    
        return redirect()->route('admin.options.index')->with('success', ['Les prix ont été mis à jour']);
    }
}

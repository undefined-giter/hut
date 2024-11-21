<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\SpecialDatePrice;
use App\Http\Requests\Admin\SpecialDatePriceRequest;

class SpecialDatePriceController extends Controller
{
    public function index(Request $request)
    {
        $sinceDays = $request->get('sincedays', 0);
        $sincedate = Carbon::now()->subDays($sinceDays);

        $specialDatesPricesArray = SpecialDatePrice::where('spe_date', '>=', $sincedate)
            ->select('id', 'spe_date', 'spe_price')
            ->orderBy('spe_date', 'asc')
            ->get();
    
        return response()->json([
            'specialDatesPricesArray' => $specialDatesPricesArray,
            'sinceDate' => $sincedate->format('d/m/Y'),
        ]);
    }
    

    public function store(SpecialDatePriceRequest $request)
    {
        $existingSpecialDate = SpecialDatePrice::where('spe_date', $request->spe_date)->first();
    
        if ($existingSpecialDate) {
            $existingSpecialDate->update(['spe_price' => $request->spe_price]);
            return response()->json(null, 204);
        }
    
        $specialDatePrice = SpecialDatePrice::create($request->all());
    
        return response()->json(null, 204);
    }

    public function show($id)
    {
        return SpecialDatePrice::findOrFail($id);
    }

    public function update(SpecialDatePriceRequest $request, $id)
    {
        $specialDatePrice = SpecialDatePrice::findOrFail($id);
        $specialDatePrice->update($request->all());

        return response()->json($specialDatePrice);
    }

    public function destroy($id)
    {
        SpecialDatePrice::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}

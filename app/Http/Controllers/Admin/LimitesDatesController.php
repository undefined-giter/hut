<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\LimitesDates;
use App\Http\Requests\Admin\LimitesDatesRequest;

class LimitesDatesController extends Controller
{
    public function index()
    {
        $dates = LimitesDates::first();
        
        if (!$dates) {
            $dates = LimitesDates::create([
                'minDate' => now()->year . '-05-01',
                'maxDate' => now()->year . '-09-30',
            ]);
        } elseif (!$dates->minDate || !$dates->maxDate) {
            if (!$dates->minDate) {
                $dates->minDate = now()->year . '-05-01';
            }
            if (!$dates->maxDate) {
                $dates->maxDate = now()->year . '-09-30';
            }
            $dates->save();
        }

        return response()->json([
            'minDate' => $dates->minDate,
            'maxDate' => $dates->maxDate,
        ]);
    }

    public function updateMinDate(LimitesDatesRequest $request)
    {
        $dates = LimitesDates::firstOrCreate([]);
        $dates->minDate = $request->validated()['minDate'];
        $dates->save();
    }

    public function updateMaxDate(LimitesDatesRequest $request)
    {
        $dates = LimitesDates::firstOrCreate([]);
        $dates->maxDate = $request->validated()['maxDate'];
        $dates->save();
    }
}

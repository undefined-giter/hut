<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\PriceCalculator;
use App\Http\Requests\ReservationRequest;


class StripeController extends Controller
{
    public function preparePayment(ReservationRequest $request)
    {
        $validatedData = $request->all();
dd($validatedData);
        session()->put('payment_data', $validatedData);

        return redirect()->route('payment.show');
    }

    public function showPaymentPage(PriceCalculator $priceCalculator)
    {dd('paiement page');
        $paymentData = session('payment_data');
    
        if (!$paymentData) {
            return redirect()->route('book')->with('error', 'Les informations de la réservation sont manquantes.');
        }
    
        $selectedOptions = collect(json_decode($paymentData['options'], true));
    
        $calculatedPrice = $priceCalculator->calculatePrice(
            $paymentData['start_date'],
            $paymentData['end_date'],
            $selectedOptions->toArray()
        );
    
        return inertia('Payment/StripePayment', [
            'price' => $calculatedPrice['res_price'],
            'nights' => $calculatedPrice['nb_of_nights'],
            'start_date' => $paymentData['start_date'],
            'end_date' => $paymentData['end_date'],
            'options' => $selectedOptions,
        ]);
    }    

    public function processPayment(Request $request)
    {
        dd('payment process');
    }
}

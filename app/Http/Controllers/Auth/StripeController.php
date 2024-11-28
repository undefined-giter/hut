<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\PriceCalculatorService;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Admin\Option;


class StripeController extends Controller
{
    public function preparePayment(ReservationRequest $request, PriceCalculatorService $priceCalculator)
    {
        $validatedData = $request->validated();
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    
        $user = Auth::user();
        $userId = $user->id;

        // Vérifications des réservations existantes
        $existingReservation = Reservation::where('user_id', $userId)
            ->where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->first();
    
        if ($existingReservation) {
            return redirect()->route('book')->with('error', 'Vous avez déjà une réservation durant cette période. Veuillez la modifier si nécessaire.');
        }
    
        $conflictingReservations = Reservation::where('user_id', '!=', $userId)
            ->where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->exists();
    
        if ($conflictingReservations) {
            return redirect()->route('book')->with('error', 'Les dates sélectionnées sont déjà réservées.');
        }
    
        $optionIds = collect($validatedData['options'])->pluck('id')->toArray();
        $validatedOptions = collect($validatedData['options']);
        $selectedOptions = Option::whereIn('id', $optionIds)->get()->map(function ($option) use ($validatedOptions) {
            $option->by_day = $validatedOptions->firstWhere('id', $option->id)['by_day'] ?? false;
            return $option;
        });
    
        $calculatedPrice = $priceCalculator->calculatePrice(
            $validatedData['start_date'],
            $validatedData['end_date'],
            $selectedOptions->toArray()
        );
    
        $stripeTax = ceil($calculatedPrice['res_price'] * 1.5 / 100);
        $total = $calculatedPrice['res_price'] + $stripeTax;
        $amount = intval(round($total, 2) * 100);
    
        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'user_id' => $userId,
                    'start_date' => $validatedData['start_date'],
                    'end_date' => $validatedData['end_date'],
                ],
            ]);
    
            session()->put('payment_data', $validatedData);
            session()->put('payment_intent_id', $paymentIntent->id);
    
            return redirect()->route('payment.show')->with([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('book')->with('error', 'Une erreur est survenue lors de la préparation du paiement : ' . $e->getMessage());
        }
    }
    

    public function showPaymentPage(PriceCalculatorService $priceCalculator)
    {
        $paymentData = session('payment_data');
        
        if (!$paymentData) {
            return redirect()->route('book')->with('error', 'Les informations de la réservation sont manquantes.');
        }

        $optionIds = collect($paymentData['options'])->pluck('id')->toArray();
        $validatedOptions = collect($paymentData['options']);
        $selectedOptions = Option::whereIn('id', $optionIds)->get()->map(function ($option) use ($validatedOptions) {
            $option->by_day = $validatedOptions->firstWhere('id', $option->id)['by_day'] ?? false;
            return $option;
        });

        $calculatedPrice = $priceCalculator->calculatePrice(
            $paymentData['start_date'],
            $paymentData['end_date'],
            $selectedOptions->toArray()
        );

        $stripeTax = ceil($calculatedPrice['res_price'] * 1.5 / 100);
        $total = $calculatedPrice['res_price'] + $stripeTax;
        $totalAmount = intval(round($total, 2) * 100);

        $clientSecret = session('clientSecret'); 

        return inertia('Stripe/index', [
            'clientSecret' => $clientSecret,
            'csrf_token' => csrf_token(),
            'nightsPrice' => $calculatedPrice['nights_price'],
            'optionsPrice' => $calculatedPrice['options_price'],
            'stripeTax' => $stripeTax,
            'total' => $total,
            'nights' => $calculatedPrice['nb_of_nights'],
            'start_date' => $paymentData['start_date'],
            'end_date' => $paymentData['end_date'],
            'options' => $selectedOptions,
            'original_options' => session('original_options'),
            'res_comment' => $paymentData['res_comment'] ?? null,
        ]);
    }


    public function processPayment(Request $request)
    {
        $paymentIntentId = $request->input('paymentIntentId');
    
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
    
            if ($paymentIntent->status === 'succeeded') {
                return redirect()->route('profile')->with('success', 'Paiement réussi et réservation confirmée!');
            } else {
                return redirect()->route('payment.show')->with('error', 'Paiement non validé.');
            }
        } catch (\Exception $e) {
            return redirect()->route('book')->with('error', 'Erreur lors de la finalisation du paiement : ' . $e->getMessage());
        }
    }
}

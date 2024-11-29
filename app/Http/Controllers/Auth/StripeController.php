<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\PriceCalculatorService;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Admin\Option;
use Illuminate\Http\Request;


class StripeController extends Controller
{
    public function showPaymentPage(ReservationRequest $request, PriceCalculatorService $priceCalculator)
    {
        $validatedData = $request->validated();
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    
        $user = Auth::user();
        $userId = $user->id;
    
        $existingReservation = Reservation::where('user_id', $userId)
            ->where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->first();
    
        if ($existingReservation) { return redirect()->route('book')->with('error', ['Vous avez déjà une réservation durant cette période. Veuillez la modifier si nécessaire.']); }
    
        $conflictingReservations = Reservation::where('user_id', '!=', $userId)
            ->where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->exists();
    
        if ($conflictingReservations) { return redirect()->route('book')->with('error', ['Les dates sélectionnées sont déjà réservées.']); }
    
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
        $total = intval(round(($calculatedPrice['res_price'] + $stripeTax), 2) * 100);
    
        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $total,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'user_id' => $userId,
                    'start_date' => $validatedData['start_date'],
                    'end_date' => $validatedData['end_date'],
                ],
            ]);
    
            return inertia('Stripe/index', [
                'clientSecret' => $paymentIntent->client_secret,
                'csrf_token' => csrf_token(),
                'nightsPrice' => $calculatedPrice['nights_price'],
                'optionsPrice' => $calculatedPrice['options_price'],
                'stripeTax' => $stripeTax,
                'total' => $total / 100,
                'nights' => $calculatedPrice['nb_of_nights'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'options' => $selectedOptions,
                'original_options' => session('original_options'),
                'res_comment' => $validatedData['res_comment'] ?? null,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('book')->with('error', ['Passez à un paiement sur place svp.<br>Erreur : ' . $e->getMessage()]);
        }
    }
    

    public function processPayment(Request $request)
    {
        $paymentIntentId = $request->input('paymentIntentId');
        if (!$paymentIntentId || !$paymentIntent->client_secret) { return redirect()->route('book')->with('error', ['Erreur lors du prcessus du paiement.']); }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            if ($paymentIntent->status === 'succeeded') {
                return redirect()->route('profile')->with('success', ['Paiement réussi et réservation confirmée!']);
            } else {
                return redirect()->route('payment.show')->with('error', ['Paiement non validé.']);
            }
        } catch (\Exception $e) {
            return redirect()->route('book')->with('error', ['Erreur lors de la finalisation du paiement : ' . $e->getMessage()]);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\PriceCalculatorService;
use App\Http\Requests\ReservationRequest;
use App\Http\Controllers\ReservationController;
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
    
        if (!$paymentIntentId) {
            return redirect()->route('book')->with('error', ['Payment Intent ID is missing.']);
        }
    
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
    
            if ($paymentIntent->status !== 'succeeded') {
                throw new \Exception(['Le paiement n\'est pas terminé.']);
            }
            
            $reservationData = $request->only(['start_date', 'end_date', 'res_comment', 'options']);
            $reservationData['payed'] = $request->input('total');
            $reservationData['card_fees'] = $request->input('stripeTax');
    
            $reservationRequest = ReservationRequest::createFromBase(new Request($reservationData));
    
            $reservationRequest->setContainer(app());
            $reservationRequest->setRedirector(app('redirect'));
    
            $reservationRequest->validateResolved();
    
            $reservationController = new ReservationController();
            return $reservationController->store($reservationRequest);
    
        } catch (\Exception $e) {
            return redirect()->route('book')->with('error', [$e->getMessage()]);
        }
    }   
}

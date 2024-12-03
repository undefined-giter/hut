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
    public function showPaymentPage(ReservationRequest $request, PriceCalculatorService $priceCalculator, ?int $id = null)
    {
        $validatedData = $request->validated();
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    
        $user = Auth::user();
        $userId = $user->id;
    
        $existingReservation = Reservation::where('user_id', $userId)
            ->where('start_date', '<', $validatedData['end_date'])
            ->where('end_date', '>', $validatedData['start_date'])
            ->first();
    
        if ($id == null && $existingReservation) { return redirect()->route('book')->with('error', ['Vous avez déjà une réservation durant cette période. Veuillez la modifier si nécessaire.']); }
    
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

        $payed = 0;
        $previous_card_fees = 0;
        $res_payed = 0;
        if ($id && $existingReservation){
            $payed = $existingReservation->payed;
            $previous_card_fees = $existingReservation->card_fees;
            $res_payed = $existingReservation->res_payed;
        }
    
        $restResToPay = $calculatedPrice['res_price'] - $res_payed;

        if($restResToPay < 0){
            return back()->with('error', ["Veuillez choisir le paiement en liquide pour être remboursés des $restResToPay € à votre arrivée, ou contactez-nous."]);
        }
        $stripeTax = ceil($restResToPay * 1.5 / 100);
        $total = intval(round((($restResToPay + $stripeTax) * 100), 2));
    
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
                'previous_card_fees' => $previous_card_fees,
                'stripeTax' => $stripeTax,
                'total' => $total / 100,
                'payed' => $payed,
                'restResToPay' => $restResToPay,
                'res_payed' => $res_payed,
                'nights' => $calculatedPrice['nb_of_nights'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'options' => $selectedOptions,
                'original_options' => session('original_options'),
                'res_comment' => $validatedData['res_comment'] ?? null,
                'reservation_id' => $id ?? null,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('book')->with('error', ['Passez à un paiement sur place svp.<br>Erreur : ' . $e->getMessage()]);
        }
    }
    

    public function processPayment(Request $request)
    {
        $paymentIntentId = $request->input('paymentIntentId');
    
        if (!$paymentIntentId) {
            return redirect()->route('book')->with('error', ['Payment Intent ID est manquant.']);
        }
    
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
    
            if ($paymentIntent->status !== 'succeeded') {
                return redirect()->route('book')->with('error', ['Le paiement par carte a échoué.<br>Merci de choisir un paiement sur place ou de nous contacter.']);
            }

            $reservationId = $request->input('reservation_id');
            $reservationData = $request->only(['start_date', 'end_date', 'res_comment', 'options']);
            $reservationData['payed'] = $request->input('total') + $request->input('payed');
            $reservationData['card_fees'] = $request->input('stripeTax') + $request->input('previous_card_fees');
            $reservationData['res_payed'] = $request->input('res_payed') + $request->input('restResToPay');
    
            $reservationRequest = ReservationRequest::createFromBase(new Request($reservationData));
            $reservationRequest->merge(['reservation_id' => $reservationId]);

            $reservationRequest->setContainer(app());
            $reservationRequest->setRedirector(app('redirect'));
    
            $reservationRequest->validateResolved();
    
            $reservationController = new ReservationController();
            return $reservationController->store($reservationRequest, $reservationId);
    
        } catch (\Exception $e) {
            return redirect()->route('book')->with('error', ['Le paiement par carte a échoué.']);
        }
    }   
}

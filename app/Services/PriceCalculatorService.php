<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PriceCalculatorService
{
    public function calculatePrice(string $startDate, string $endDate, array $selectedOptions, ?int $id): array
    {
        $prices = DB::table('prices')
        ->whereIn('key', ['price_per_night', 'price_per_night_for_2_and_more_nights', 'percent_reduced_week'])
        ->pluck('value', 'key');

        $pricePerNight = $prices['price_per_night'];
        $pricePerNightFor2AndMoreNights = $prices['price_per_night_for_2_and_more_nights'];
        $percentReducedWeek = $prices['percent_reduced_week'];

        $specialDatesPricesArray = DB::table('specials_dates_prices')
            ->where('spe_date', '>=', Carbon::now())
            ->select('spe_date', 'spe_price')
            ->orderBy('spe_date', 'asc')
            ->get();
        
        $startDateTime = new \DateTime($startDate);
        $endDateTime = new \DateTime($endDate);
        $nbOfNights = $startDateTime->diff($endDateTime)->days;
        
        $dateArray = [];
        while ($startDateTime < $endDateTime) {
            $dateArray[] = $startDateTime->format('Y-m-d');
            $startDateTime->modify('+1 day');
        }
   
        $totalSpecialPrice = 0;
        $specialDates = $specialDatesPricesArray->pluck('spe_date')->toArray();
        
        foreach ($specialDatesPricesArray as $specialDate) {
            if (in_array($specialDate->spe_date, $dateArray)) {
                $totalSpecialPrice += (float) $specialDate->spe_price;
            }
        }
    
        $totalRegularPrice = 0;
        foreach ($dateArray as $date) {
            $dayOfWeek = (new \DateTime($date))->format('N');
            $isWeekend = in_array($dayOfWeek, [5, 6, 7]);
    
            if (!in_array($date, $specialDates)) {
                if ($nbOfNights > 1) {
                    $totalRegularPrice += $isWeekend
                        ? $pricePerNightFor2AndMoreNights
                        : $pricePerNightFor2AndMoreNights * (1 - $percentReducedWeek / 100);
                } else {
                    $totalRegularPrice += $isWeekend
                        ? $pricePerNight
                        : $pricePerNight * (1 - $percentReducedWeek / 100);
                }
            }
        }

        
        $optionsPrice = 0;
        foreach ($selectedOptions as $option) {
            
            $optionPrice = (float)($option['price']);
            $isByDay = $option['by_day'] ?? false;
        
            if ($isByDay) {
                $optionsPrice += $optionPrice * max($nbOfNights, 1);
            } else {
                $optionsPrice += $optionPrice;
            }
        }
        
        $res_price = $totalSpecialPrice + $totalRegularPrice + $optionsPrice;

        if($res_price < 1 && $res_price > -1){ $res_price = 0; }

        return [ 
            'nights_price' => $totalSpecialPrice + $totalRegularPrice,
            'options_price' => $optionsPrice,
            'res_price' => $res_price,
            'nb_of_nights' => $nbOfNights,
        ];
    }
}
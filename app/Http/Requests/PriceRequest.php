<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'price_per_night' => 'required|integer|min:0',
            'price_per_night_for_2_and_more_nights' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'price_per_night.required' => 'Le prix par nuit est requis.',
            'price_per_night.integer' => 'Le prix par nuit doit être un entier.',
            'price_per_night.min' => 'Le prix par nuit doit être supérieur ou égal à 0.',
            'price_per_night_for_2_and_more_nights.required' => 'Le prix pour 2+ nuits est requis.',
            'price_per_night_for_2_and_more_nights.integer' => 'Le prix pour 2+ nuits doit être un entier.',
            'price_per_night_for_2_and_more_nights.min' => 'Le prix pour 2+ nuits doit être supérieur ou égal à 0.',
        ];
    }
}

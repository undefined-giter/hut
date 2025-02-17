<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SpecialDatePriceRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'spe_date' => 'required|date',
            'spe_price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'spe_date.required' => 'La date est obligatoire.',
            'spe_date.date' => 'La date doit être au format valide (AAAA-MM-JJ).',
            'spe_price.required' => 'Le prix est obligatoire.',
            'spe_price.numeric' => 'Le prix doit être un nombre.',
        ];
    }

    protected function failedAuthorization()
    {
        abort(403, 'Vous n\'êtes pas autorisé à effectuer cette action.');
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SpecialDatePriceRequest extends FormRequest
{
    public function authorize()
    {
        // Vérifie si l'utilisateur est authentifié et a le rôle 'admin'
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'spe_date' => 'required|date',
            'spe_price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'spe_date.required' => 'La date est obligatoire.',
            'spe_date.date' => 'La date doit être au format valide (AAAA-MM-JJ).',
            'spe_price.required' => 'Le prix est obligatoire.',
            'spe_price.numeric' => 'Le prix doit être un nombre.',
            'spe_price.min' => 'Le prix doit être supérieur ou égal à zéro.',
        ];
    }

    protected function failedAuthorization()
    {
        abort(403, 'Vous n\'êtes pas autorisé à effectuer cette action.');
    }
}

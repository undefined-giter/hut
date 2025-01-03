<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LimitesDatesRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'minDate' => 'required|date',
            'maxDate' => 'required|date|after_or_equal:minDate',
        ];
    }

    public function messages()
    {
        return [
            'maxDate.after_or_equal' => 'La date maximale doit être après ou égale à la date minimale.',
        ];
    }

    protected function failedAuthorization()
    {
        abort(403, 'Vous n\'êtes pas autorisé à changer les dates limites.');
    }
}

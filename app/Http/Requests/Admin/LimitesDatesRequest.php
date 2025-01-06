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
            'minDate' => 'sometimes|required|date',
            'maxDate' => 'sometimes|required|date',
        ];
    }

    protected function failedAuthorization()
    {
        abort(403, 'Vous n\'êtes pas autorisé à changer les dates limites.');
    }
}

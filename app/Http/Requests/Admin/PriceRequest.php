<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->role, ['admin', 'fake_admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'price_per_night' => 'required|integer|min:0',
            'price_per_night_for_2_and_more_nights' => 'required|integer|min:0',
            'percent_reduced_week' => 'required|integer|max:100',
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'price_per_night.required' => 'Le prix par nuit est requis.',
            'price_per_night.integer' => 'Le prix par nuit doit être un entier.',
            'price_per_night.min' => 'Le prix par nuit doit être supérieur ou égal à 0.',
            'price_per_night_for_2_and_more_nights.required' => 'Le prix pour 2+ nuits est requis.',
            'price_per_night_for_2_and_more_nights.integer' => 'Le prix pour 2+ nuits doit être un entier.',
            'price_per_night_for_2_and_more_nights.min' => 'Le prix pour 2+ nuits doit être supérieur ou égal à 0.',
            'percent_reduced_week.required' => 'La réduction pour les jours de semaine est requise (0 est possible).',
            'percent_reduced_week.numeric' => 'La réduction pour les jours de semaine doit être un nombre.',
            'percent_reduced_week.max' => 'Doit être inférieur ou égal à 100.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|regex:/^0[1-9][0-9]{8}$/',
            'message' => 'required|string|min:20|max:510',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'L\'email est obligatoire.',
            'phone.regex' => 'Le numéro de téléphone doit commencer par 0 et comporter 10 chiffres.',
        ];
    }
}

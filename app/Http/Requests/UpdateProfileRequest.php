<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|min:2|max:255',
            'name2' => 'nullable|string|min:2|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'phone' => 'nullable|string|size:10',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.size' => 'Le nom doit faire entre 2 et 255 caractères.',
            'email.required' => 'L\'email est obligatoire.',
            'email.regex' => 'L\'adresse email doit contenir un domaine valide (.com, .fr, etc).',
            'phone.size' => 'Le numéro de téléphone doit comporter exactement 10 chiffres.',
            'picture.image' => 'Le fichier doit être une image.',
        ];
    }
}

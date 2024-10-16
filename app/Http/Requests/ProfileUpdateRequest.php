<?php

// namespace App\Http\Requests;

// use App\Models\User;
// use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Rule;

// class ProfileUpdateRequest extends FormRequest
// {
//     public function rules(): array
//     {
//         return [
//             'name' => ['required', 'string', 'max:255'],
//             'email' => [
//                 'required', 
//                 'string', 
//                 'email', 
//                 'max:255', 
//                 Rule::unique(User::class)
//                     ->ignore($this->user()->id) // Ignorer l'utilisateur actuel pour l'email unique
//                     ->whereNull('deleted_at')
//             ],
//         ];
//     }

//     public function messages(): array
//     {
//         return [
//             'name.required' => 'Le nom est obligatoire.',
//             'name.string' => 'Le nom doit être une chaîne de caractères.',
//             'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            
//             'email.required' => 'L\'email est obligatoire.',
//             'email.string' => 'L\'email doit être une chaîne de caractères.',
//             'email.email' => 'L\'adresse email doit être valide.',
//             'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
//             'email.unique' => 'Cet email est déjà utilisé. Veuillez en choisir un autre.',
//         ];
//     }

//     protected function prepareForValidation()
//     {
//         $this->merge([
//             'email' => strtolower($this->email),
//         ]);
//     }
// }

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Autoriser tous les utilisateurs
    }

    /**
     * Règles de validation qui s'appliquent à la requête.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email',
            'message' => 'required|string|min:3|max:500',
        ];
    }
}

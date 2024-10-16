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
        return true;
    }

    /**
     * Règles de validation qui s'appliquent à la requête.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|regex:/^0[1-9][0-9]{8}$/',
            'message' => 'required|string|min:20|max:510',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->email) && empty($this->phone)) {
                $validator->errors()->add('email', 'Vous devez remplir au moins l\'email ou le téléphone.');
                $validator->errors()->add('phone', 'Vous devez remplir au moins le téléphone ou l\'email.');
            }
        });
    }
}

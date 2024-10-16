<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'available' => 'required|boolean',
            'preselected' => 'required|boolean',
            'by_day' => 'sometimes|boolean',
            'by_day_display' => 'sometimes|boolean',
            'by_day_preselected' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom de l\'option est requis.',
        ];
    }
}

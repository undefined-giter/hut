<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $optionsJson = $this->input('options');
        $optionsData = json_decode($optionsJson, true) ?? [];
        if (!is_array($optionsData)) { $optionsData = []; }

        $this->merge([
            'options' => $optionsData,
        ]);
    }

    public function rules()
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'nights' => 'required|integer|min:1',
            'res_comment' => 'nullable|max:510',
            'res_price' => 'required|numeric',
            'options' => 'nullable|array',
            'options.*.id' => 'nullable|exists:options,id',
            'options.*.by_day' => 'nullable|boolean',
        ];
    }
}
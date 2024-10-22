<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $optionsJson = $this->input('options');
        $optionsData = json_decode($optionsJson, true) ?? [];
        if (!is_array($optionsData)) {
            $optionsData = [];
        }

        $this->merge([
            'options' => $optionsData,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
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

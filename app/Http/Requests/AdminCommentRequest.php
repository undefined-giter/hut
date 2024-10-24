<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCommentRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules()
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'content' => 'required|string|max:1000',
            ];
        }
        
        return [
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ];
    }
}

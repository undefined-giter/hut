<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminCommentRequest extends FormRequest
{
    public function authorize()
    {
        $user = Auth::user();
        return $user && in_array($user->role, ['admin', 'fake_admin']);
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

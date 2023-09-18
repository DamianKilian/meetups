<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'currentPassword' => 'required|current_password',
            'newPassword' => 'required|string|min:8|confirmed|different:currentPassword',
        ];
    }
}

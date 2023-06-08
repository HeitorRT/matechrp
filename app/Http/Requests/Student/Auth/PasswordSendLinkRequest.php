<?php

namespace App\Http\Requests\Student\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordSendLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:students,email',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O email é inválido',
            'email.exists' => 'O email não foi encontrado'
        ];
    }
}

<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$this->user->id}",
            'password' => 'nullable|confirmed',
            'active' => 'nullable|boolean',
            'cpf' => 'nullable|string',
            'phone' => 'nullable',
            'is_system_user' => 'nullable|boolean',
            'is_teacher' => 'nullable|boolean',
            'is_partner' => 'nullable|boolean',
            'whereby_link' => 'nullable|url',
            'role_ids' => 'nullable|array',
            'address.cep' => 'nullable|string',
            'address.street' => 'nullable|string',
            'address.number' => 'nullable|string',
            'address.district' => 'nullable|string',
            'address.complement' => 'nullable|string',
            'address.state' => 'nullable|string',
            'address.city' => 'nullable|string',
            'address.country' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Preencha o nome',
            'email.required' => 'Preencha o email',
            'email.email' => 'Insira um email válido',
            'email.unique' => 'O email já está sendo utilizado por outro usuário',
            'whereby_link.url' => 'Insira um link válido',
        ];
    }
}

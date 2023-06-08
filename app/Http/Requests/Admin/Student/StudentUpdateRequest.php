<?php

namespace App\Http\Requests\Admin\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            'email' => "required|email|unique:students,email,{$this->student->id}",
            'active' => 'nullable|boolean',
            'cpf' => 'nullable|string',
            'phone' => 'nullable',
            'customer_cpf' => 'required|string',
            'customer_phone' => 'required|string',
            'equal_data' => 'nullable|boolean',
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
            'customer_cpf.required' => 'Preencha o cpf do cliente',
            'customer_phone.required' => 'Preencha o telefone do cliente',
        ];
    }
}

<?php

namespace App\Http\Requests\Admin\Section;

use Illuminate\Foundation\Http\FormRequest;

class SectionUpdateRequest extends FormRequest
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
            'contents' => 'nullable|array',
            'contents.*.id' => 'nullable|exists:contents,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Preencha o nome'
        ];
    }
}

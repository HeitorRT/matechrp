<?php

namespace App\Http\Requests\Admin\Indication;

use Illuminate\Foundation\Http\FormRequest;

class IndicationIndexRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Add prefix 'filters' before field rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filters.name' => 'nullable|string',
            'filters.email' => 'nullable|string',
        ];
    }

    /**
     * Add prefix 'filters' before field messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}

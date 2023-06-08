<?php

namespace App\Http\Requests\Admin\Popup;

use Illuminate\Foundation\Http\FormRequest;

class PopupIndexRequest extends FormRequest
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
            'filters.description' => 'nullable|string',
            'filters.start_at' => 'nullable|date_format:d/m/Y H:i',
            'filters.end_at' => 'nullable|date_format:d/m/Y H:i',
        ];
    }

    /**
     * Add prefix 'filters' before field messages
     *
     * @return array
     */
    public function messages(): array
    {
        $dateFormatForExample = now()->format('d/m/Y H:i');

        return [
            'filters.start_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
            'filters.end_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
        ];
    }
}

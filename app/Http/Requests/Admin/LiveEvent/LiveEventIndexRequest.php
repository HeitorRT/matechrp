<?php

namespace App\Http\Requests\Admin\LiveEvent;

use App\Enums\LiveEventTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class LiveEventIndexRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Add prefix 'filters' before field rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'filters.name' => 'nullable|string',
			'filters.start_at' => 'nullable|date_format:d/m/Y H:s',
            'filters.end_at' => 'nullable|date_format:d/m/Y H:s',
            'filters.teacher_id' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Add prefix 'filters' before field messages
     *
     * @return array
     */
    public function messages(): array
    {
        $dateFormatForExample = now()->format('d/m/Y H:s');

        return [
            'filters.start_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
            'filters.end_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
        ];
    }
}

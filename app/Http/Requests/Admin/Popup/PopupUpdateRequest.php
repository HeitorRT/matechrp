<?php

namespace App\Http\Requests\Admin\Popup;

use Illuminate\Foundation\Http\FormRequest;

class PopupUpdateRequest extends FormRequest
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
            'description' => 'required|string',
            'image' => 'nullable',
            'start_at' => 'nullable|date_format:d/m/Y H:i|before:end_at',
            'end_at' => 'nullable|date_format:d/m/Y H:i|after:start_at',
            'content_ids' => 'nullable|array',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        $dateFormatForExample = now()->format('d/m/Y H:i');
        $dateFormatMoreOneMinute = now()->addMinute(1)->format('d/m/Y H:i');

        return [
            'description.required' => 'Preencha a descrição',
            'start_at.date_format' => "Informe a data e hora de início corretamente. Exemplo: {$dateFormatForExample}",
            'start_at.after' => "Informe a data e hora de início posterior a {$dateFormatMoreOneMinute}",
            'start_at.before' => 'Informe a data e hora de início anterior a data e hora de término',
            'end_at.date_format' => "Informe a data e hora de término corretamente. Exemplo: {$dateFormatForExample}",
            'end_at.after' => 'Informe a data e hora de término posterior a data e hora de início',
        ];
    }
}

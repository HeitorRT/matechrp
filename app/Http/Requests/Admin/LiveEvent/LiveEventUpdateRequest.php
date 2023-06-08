<?php

namespace App\Http\Requests\Admin\LiveEvent;

use Illuminate\Foundation\Http\FormRequest;

class LiveEventUpdateRequest extends FormRequest
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
            'description' => 'nullable|string',
            'campaign_ids' => 'nullable|array',
            'responsible_id' => 'required|exists:users,id',
            'start_at' => 'required|date_format:d/m/Y H:i|after:'.now()->addMinute(1)->format('d/m/Y H:i').'|before:end_at',
            'end_at' => 'required|date_format:d/m/Y H:i|after:start_at',
            'embed' => 'required|string',
            'has_live_offer'=> 'nullable',
            'name_offer'=> 'nullable|string',
            'description_offer'=> 'nullable|string',
            'embed_offer'=> 'nullable|url',
            'materials' => 'nullable|array',
            'image' => 'nullable',
            'has_link_with_content' => 'required|boolean',
            "content_id" => 'required_if:has_link_with_content,true',
            "linkable_id" => 'required_unless:linkable_type,content',
            "linkable_type" => "nullable|in:content,season,chapter",
        ];
    }

    public function messages()
    {
        $dateFormatForExample = now()->format('d/m/Y H:i');

        $dateFormatMoreOneMinute = now()->addMinute(1)->format('d/m/Y H:i');

        return [
            'name.required' => 'Preencha o nome',
            'responsible_id.required' => 'Selecione o responsável pelo evento',
            'start_at.required' => 'Informe a data e hora de início',
            'start_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
            'start_at.after' => "Informe a data e hora de início posterior a {$dateFormatMoreOneMinute}",
            'start_at.before' => 'Informe a data e hora de início anterior a data e hora de término',
            'end_at.required' => 'Informe a data e hora final',
            'end_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
            'end_at.after' => 'Informe a data e hora de término posterior a data e hora de início',
            'embed.required' => 'Preencha o link',
            'embed.url' => 'Deve ser do formato de url',
            'embed_offer.url' => 'Deve ser do formato de url',
            'content_id.required_if' => 'Vincule a um conteúdo',
            'linkable_id.required_unless' => 'Vincule ao final do conteúdo ou selecione temporada ou episódio'
        ];
    }
}

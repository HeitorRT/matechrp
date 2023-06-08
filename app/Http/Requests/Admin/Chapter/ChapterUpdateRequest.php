<?php

namespace App\Http\Requests\Admin\Chapter;

use App\Enums\ChapterPlayerEnum;
use Illuminate\Foundation\Http\FormRequest;

class ChapterUpdateRequest extends FormRequest
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
            'description' => 'nullable|max:500',
            'number' => 'nullable|integer',
            'duration' => 'nullable|date_format:H:i',
            'cast' => 'nullable|string',
            'direction' => 'nullable|string',
            'main_player' => "required|in:" . implode(',', ChapterPlayerEnum::toValues()),
            'vimeo_link' => 'nullable|url',
            'vimeo_embed' => 'nullable|string',
            'sambatech_link' => 'nullable|url',
            'sambatech_embed' => 'nullable|string',
            'image' => 'nullable',
            'embed' => 'nullable|url',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        $dateFormatForExample = now()->format('H:i');

        return [
            'name.required' => 'Preencha o nome',
            'description.max' => 'A descrição deve ter no máximo 500 caracteres',
            'duration.date_format' => "Informe a data corretamente. Exemplo: {$dateFormatForExample}",
            'vimeo_link.url' => 'O link do vimeo deve ser uma URL válida',
            'sambatech_link.url' => 'O link do sambatech deve ser uma URL válida',
            'embed.url' => 'O link do embed deve ser uma URL válida',

        ];
    }
}

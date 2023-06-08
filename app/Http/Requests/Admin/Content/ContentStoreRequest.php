<?php

namespace App\Http\Requests\Admin\Content;

use App\Enums\ContentAuthorEnum;
use App\Enums\ContentProductionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class ContentStoreRequest extends FormRequest
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
            'tags' => 'nullable|array',
            'launch_start_at' => 'required|date_format:d/m/Y H:i|before:launch_end_at',
            'launch_end_at' => 'required|date_format:d/m/Y H:i|after:launch_start_at',
            'end_at' => 'after_or_equal:launch_end_at|date_format:d/m/Y H:i',
            'author' => "required|in:" . implode(',', ContentAuthorEnum::toValues()),
            'production_type' => "required|in:" . implode(',', ContentProductionTypeEnum::toValues()),
            'closing_date' => 'nullable|date_format:d/m/Y',
            'has_seasons' => 'nullable',
            'number_of_seasons' => 'required_if:has_seasons,true',
            'highlight' => 'nullable',
            'responsible_id' => 'required_if:author,outro',
            'sections' => 'nullable|array',
            'genres' => 'nullable|array',
            'contents_of_the_same_collection' => 'nullable|array',
            'similar_contents' => 'nullable|array',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable',
            'secondary_image' => 'nullable',
            'description_image' => 'nullable',
            'screensaver_image' => 'nullable',
            'description' => 'nullable|max:500',
            'active' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        $contentAuthorEnum = collect(ContentAuthorEnum::toLabels())->implode(', ', ' ou ');
        $contentProductionTypeEnum = collect(ContentProductionTypeEnum::toLabels())->implode(', ', ' ou ');

        $dateFormatForExample = now()->format('d/m/Y H:i');

        return [
            'name.required' => 'Preencha o nome',
            'author.required' => 'Escolha o autor da produção',
            'author.in' => "O valor escolhido deve ser entre {$contentAuthorEnum}",
            'production_type.required' => 'Escolha o tipo de produção',
            'production_type.in' => "O valor escolhido deve ser entre {$contentProductionTypeEnum}",
            'responsible_id.required_if' => 'Insira o responsável pela produção',
            'launch_start_at.required' => 'Informe a data e hora de início',
            'launch_start_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
            'launch_start_at.before' => 'Informe a data e hora de início anterior a data e hora de término',
            'launch_end_at.required' => 'Informe a data e hora final',
            'launch_end_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
            'launch_end_at.after' => 'Informe a data e hora de término posterior a data e hora de início',
            'end_at.after_or_equal' => 'O prazo de encerramento dever ser igual ou posterior a data e hora de término do lançamento',
            'description.max' => 'A descrição deve ter no máximo 500 caracteres.',
        ];
    }
}

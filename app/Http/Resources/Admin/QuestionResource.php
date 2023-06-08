<?php

namespace App\Http\Resources\Admin;

use App\Models\Alternative;
use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Question */
        $question = $this->resource;

        return [
            'id' => $question->id,
            'title' => $question->title,
            'text' => $question->text,
            'answer_type' => $question->answer_type,
            'number' => $question->number,
            'video' => $question->video,
            'audio' => $question->audio,
            'image' => $question->image,
            'has_video' => $question->has_video,
            'has_audio' => $question->has_audio,
            'has_image' => $question->has_image,
            'alternatives' => $question->alternatives->map(fn (Alternative $alternative) => [
                'name' => $alternative->name,
                'is_correct' => $alternative->is_correct
            ])
        ];
    }
}

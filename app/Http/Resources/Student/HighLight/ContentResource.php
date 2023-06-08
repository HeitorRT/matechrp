<?php

namespace App\Http\Resources\Student\HighLight;

use App\Helpers\Seeder\Random;
use App\Http\Resources\Student\HighLight\Content\ChapterResource;
use App\Http\Resources\Student\HighLight\Content\FileResource;
use App\Models\Chapter;
use App\Models\Content;
use App\Models\Quizz;
use App\Models\Season;
use App\Models\Student;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Content */
        $content = $this->resource;

        /** @var Student */
        $authStudent = auth()->user();

        return [
            'type' => 'content',
            'id' => $content->id,
            'name' => $content->name,
            'description' => $content->description,
            'image' => $content->image,
            'has_seasons' => $content->has_seasons,
            'count_seasons' => $content->seasons->count(),
            'genres_name' => $content->genres->pluck('name')->join(', ', ' e '),
            'category_name' => $content->category->name,
            'responsible_name' => $content->responsible->name,
            'is_on_the_student_list' => (bool) $content->studentList()->wherePivot('student_id', $authStudent->id)->count(),
            'year' => $content->created_at->format('Y'),
            'files' => FileResource::collection($content->files),
            // 'backstage' => ExtraResource::collection($content->backstage),
            // 'debates' => ExtraResource::collection($content->debates),
            // 'trailers' => ExtraResource::collection($content->trailers),

            'quizzes' => $content->quizzes->map(function(Quizz $quizz) {
                return [
                    'id' => $quizz->id,
                    'name' => $quizz->name,
                    'description' => $quizz->description,
                    'image' => Random::image(),
                    'count_questions' => $quizz->questions->count(),
                ];
            }),
            $this->mergeWhen($content->has_seasons, [
                'seasons' => $content->seasons->map(function(Season $season) {
                    return [
                        'id' => $season->id,
                        'name' => $season->name,
                        'number' => $season->number,
                        'number_of_chapters' => $season->number_of_chapters,
                        'image' => $season->image,
                        'chapters' => ChapterResource::collection($season->chapters),
                    ];
                }),
            ]),
            $this->mergeUnless($content->has_seasons, [
                'chapter' => new ChapterResource($content->chapter)
            ]),
        ];
    }
}

<?php

namespace App\Http\Resources\Admin\Content;

use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\GenreResource;
use App\Http\Resources\Admin\ResponsibleResource;
use App\Http\Resources\Admin\SectionResource;
use App\Models\Content;
use App\Models\Section;
use App\Models\User;
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

        return [
            'id' => $content->id,
            'name' => $content->name,
            'tags' => $content->tags,
            'category_id' => $content->category_id,
            'category' => new CategoryResource($content->category),
            'launch_start_at' => $content->launch_start_at ? $content->launch_start_at->format('d/m/Y H:i') : null,
            'launch_end_at' => $content->launch_end_at ? $content->launch_end_at->format('d/m/Y H:i') : null,
            'end_at' => $content->end_at ? $content->end_at->format('d/m/Y H:i') : null,
            'sections' => $content->sectionsOrderedByName->map(fn(Section $section) => [
                'id' => $section->id,
                'name' => $section->name,
            ]),
            'genres' => GenreResource::collection($content->genres),
            'highlight' => $content->highlight,
            'author' => $content->author,
            'production_type' => $content->production_type,
            'responsible_id' => $content->responsible_id,
            'responsible' => new ResponsibleResource($content->responsible),
            'image' => $content->image,
            'secondary_image' => $content->secondary_image,
            'description_image' => $content->description_image,
            'screensaver_image' => $content->screensaver_image,
            'contents_of_the_same_collection' => TagResource::collection($content->contentsOfTheSameCollection),
            'similar_contents' => TagResource::collection($content->similarContents),
            'has_seasons' => $content->has_seasons,
            'number_of_seasons' => $content->number_of_seasons,
            'count_seasons' => $content->seasons->count(),
            'description' => $content->description,
            'active' => $content->active,
        ];
    }
}

<?php

namespace App\Http\Resources\Student\HighLight\Content;

use App\Models\Chapter;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Chapter */
        $chapter = $this->resource;

        return [
            'id' => $chapter->id,
            'name' => $chapter->name,
            'description' => $chapter->description,
            'image' => $chapter->image,
            'duration' => $chapter->duration ? $chapter->duration->format("H\hi\m") : null
        ];
    }
}

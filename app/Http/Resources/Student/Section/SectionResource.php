<?php

namespace App\Http\Resources\Student\Section;

use App\Http\Resources\Student\HighLight\ContentResource;
use App\Models\Content;
use App\Models\Section;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Section */
        $section = $this->resource;

        return [
            'id' => $section->id,
            'name' => $section->name,
            'contents' => ContentResource::collection($section->contents)
        ];
    }
}

<?php

namespace App\Http\Resources\Admin;

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
            'identifier' => $section->identifier,
            'name' => $section->name,
            'can_delete' => $section->can_delete,
            'sort_number' => $section->sort_number,
            'contents' => $section->contents->map(fn(Content $content) => [
                'id' => $content->id,
                'name' => $content->name,
                'sort_number' => $content->sort_number,
                'image'  => $content->image,
            ]),
        ];
    }
}

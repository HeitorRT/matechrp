<?php

namespace App\Http\Resources\Student\Content;

use App\Models\Content;
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
            'description' => $content->description,
            'image' => $content->image,
            'secondary_image' => $content->secondary_image,
            'description_image' => $content->description_image,
            'screensaver_image' => $content->screensaver_image,
            'has_seasons' => $content->has_seasons,
        ];
    }
}

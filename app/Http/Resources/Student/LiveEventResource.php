<?php

namespace App\Http\Resources\Student;

use App\Http\Resources\Student\HighLight\ContentResource;
use App\Models\LiveEvent;
use App\Models\Material;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var LiveEvent */
        $liveEvent = $this->resource;

        return [
            'type' => 'liveEvent',
            'id' => $liveEvent->id,
            'name' => $liveEvent->name,
            'description' => $liveEvent->description,
            'image' => $liveEvent->image,
            'start_at' => $liveEvent->start_at,
            'embed' => $liveEvent->embed,
            'content' => $liveEvent->content,
            'materials' => MaterialResource::collection($liveEvent->materials),
            'has_link_with_content' => $liveEvent->has_link_with_content,
            'content' => new ContentResource($liveEvent->content),
            'linkable_type'=> $liveEvent->getLinkableTypeParse(),
            'linkable_id'=> $liveEvent->linkable_id
        ];
    }
}

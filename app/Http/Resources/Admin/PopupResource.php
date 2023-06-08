<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\Content\ContentResource;
use App\Models\Popup;
use Illuminate\Http\Resources\Json\JsonResource;

class PopupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Popup */
        $popup = $this->resource;

        return [
            'id' => $popup->id,
            'description' => $popup->description,
            'image' => $popup->image,
            'start_at' => $popup->start_at ? $popup->start_at->format('d/m/Y H:i') : null,
            'end_at' => $popup->end_at ? $popup->end_at->format('d/m/Y H:i') : null,

            /** Relations */
            'contents' => ContentResource::collection($popup->contents),
            'content_ids' => $popup->content_ids,
        ];
    }
}

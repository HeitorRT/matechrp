<?php

namespace App\Http\Resources\Admin\Content;

use App\Models\Extra;
use Illuminate\Http\Resources\Json\JsonResource;

class ExtraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Extra */
        $extra = $this->resource;

        return [
            'id' => $extra->id,
            'name' => $extra->name,
            'type' => $extra->type,
            'player' => $extra->player,
            'embed' => $extra->embed,
            'content_id' => $extra->content_id,
            'file' => $extra->file,
            'is_image' => $extra->is_image
        ];
    }
}

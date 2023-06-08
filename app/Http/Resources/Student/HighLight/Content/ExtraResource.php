<?php

namespace App\Http\Resources\Student\HighLight\Content;

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
            'player' => $extra->player,
            'embed' => $extra->embed,
        ];
    }
}

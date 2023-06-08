<?php

namespace App\Http\Resources\Student\HighLight;

use App\Models\Meeting;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Meeting */
        $meeting = $this->resource;

        return [
            'id' => $meeting->id,
            'name' => $meeting->name,
            'description' => $meeting->description,
            'image' => $meeting->image,
            'start_at' => $meeting->start_at,
            'type' => 'meeting'
        ];
    }
}

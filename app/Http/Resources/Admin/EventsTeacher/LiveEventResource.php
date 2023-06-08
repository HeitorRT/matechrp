<?php

namespace App\Http\Resources\Admin\EventsTeacher;

use App\Models\LiveEvent;
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
            'id' => $liveEvent->id,
            'name' => $liveEvent->name,
            'type' => $liveEvent->event_type,
            'number_of_students' => null,
            'start_at' => $liveEvent->start_at ? $liveEvent->start_at->format('d/m/Y H:i') : null,
            'hour_at' => $liveEvent->start_at ? $liveEvent->start_at->format('H:i') : null,
            'next_event_date' => $liveEvent->start_at ? $liveEvent->start_at->format('Y-m-d H:i') : null,
            'students_count' => null,
            'type_event' => 'liveEvent'
        ];
    }
}

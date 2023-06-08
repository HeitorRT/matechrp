<?php

namespace App\Http\Resources\Admin\EventsTeacher;

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
            'type' => $meeting->type,
            'number_of_students' => $meeting->number_of_students,
            'start_at' => $meeting->start_at ? $meeting->start_at->format('d/m/Y H:i') : null,
            'hour_at' => $meeting->start_at ? $meeting->start_at->format('H:i') : null,
            'next_event_date' => $meeting->start_at ? $meeting->start_at->format('Y-m-d H:i') : null,
            'students_count' => $meeting->students->count(),
            'type_event' => 'meeting'
        ];
    }
}

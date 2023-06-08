<?php

namespace App\Http\Resources\Admin;

use App\Models\Meeting;
use App\Models\Student;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
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
            'started_at' => $meeting->started_at ? $meeting->started_at->format('d/m/Y H:i:s') : null,
            'end_at' => $meeting->end_at ? $meeting->end_at->format('d/m/Y H:i') : null,
            'ended_at' => $meeting->ended_at ? $meeting->ended_at->format('d/m/Y H:i:s') : null,
            'has_live_offer' => $meeting->has_live_offer,
            'name_offer' => $meeting->name_offer,
            'description_offer' => $meeting->description_offer,
            'embed_offer' => $meeting->embed_offer,
            'offer_available' => $meeting->offer_available,
            'teacher_id' => $meeting->teacher_id,
            'teacher' => [
                'id' => $meeting->teacher->id,
                'name' => $meeting->teacher->name,
                'whereby_link' => $meeting->teacher->whereby_link,
            ],
            'groups' => $meeting->group_ids,
            'image' => $meeting->image,
            'tags' => $meeting->tags,
            'students' => $meeting->students->sortBy('name')->map(fn(Student $student) => [
                'id' => $student->id,
                'name' => $student->name,
            ])->toArray(),
            'materials' => MaterialResource::collection($meeting->materials),
            'has_link_with_content' => $meeting->has_link_with_content,
            'content_id' => $meeting->content_id,
            'content' => [
                'id' => $meeting->content->id,
                'name' => $meeting->content->name,
                'has_seasons' => $meeting->content->has_seasons
            ],
            'linkable_type'=> $meeting->getLinkableTypeParse(),
            'linkable_id'=> $meeting->linkable_id,
            'status' => $meeting->status->label,
        ];
    }
}

<?php

namespace App\Http\Resources\Student;

use App\Models\ScheduledNotification;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduledNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var ScheduledNotification */
        $scheduledNotification = $this->resource;

        return [
            'id' => $scheduledNotification->id,
            'text' => $scheduledNotification->notification->content_pusher,
            'title' => $scheduledNotification->notification->name,
            'send_at_by_pusher' => $scheduledNotification->send_at_by_pusher,
            'created_at'  => $scheduledNotification->created_at,
        ];
    }
}

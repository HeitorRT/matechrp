<?php

namespace App\Http\Resources\Admin;

use App\Models\Notification;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Notification */
        $notification = $this->resource;

        return [
            'id' => $notification->id,
            'identifier' => $notification->identifier,
            'name' => $notification->name,
            'mandatory' => $notification->mandatory,
            'send_by_email' => $notification->send_by_email,
            'send_by_whatsapp' => $notification->send_by_whatsapp,
            'send_by_sms' => $notification->send_by_sms,
            'send_by_pusher' => $notification->send_by_pusher,
            'content_pusher' => $notification->content_pusher,
            'content_email' => $notification->content_email,
            'content_sms' => $notification->content_sms,
            'content_whatsapp' => $notification->content_whatsapp,
            'active' => $notification->active,
        ];
    }
}

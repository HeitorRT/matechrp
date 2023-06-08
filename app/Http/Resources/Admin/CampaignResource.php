<?php

namespace App\Http\Resources\Admin;

use App\Models\Campaign;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Campaign */
        $campaign = $this->resource;

        return [
            'id' => $campaign->id,
            'name' => $campaign->name,
            'start_at' => $campaign->start_at ? $campaign->start_at->format('d/m/Y') : null,
            'end_at' => $campaign->end_at ? $campaign->end_at->format('d/m/Y') : null,
            'orders_count' => $campaign->orders->count()
        ];
    }
}

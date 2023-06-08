<?php

namespace App\Http\Resources\Admin\Installment;

use App\Http\Resources\Admin\Order\OrderResource;
use App\Models\Installment;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Installment */
        $installment = $this->resource;

        return [
            'id' => $installment->id,
            'order' => new OrderResource($installment->order),
            'order_id' => $installment->order_id,
            'payment_method' => $installment->payment_method,
            'status' => $installment->status,
            'payment_value' => $installment->payment_value,
            'installment' => $installment->installment,
            'expiration_at' => $installment->expiration_at ? $installment->expiration_at->format('d/m/Y') : null,
            'expiration_original_at' => $installment->expiration_original_at ? $installment->expiration_original_at->format('d/m/Y') : null,
            'payday_at' => $installment->payday_at ? $installment->payday_at->format('d/m/Y') : null,
        ];
    }
}

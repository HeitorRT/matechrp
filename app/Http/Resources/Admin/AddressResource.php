<?php

namespace App\Http\Resources\Admin;

use App\Models\Address;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Address */
        $address = $this->resource;

        return [
            'cep' => $address->cep,
            'street' => $address->street,
            'number' => $address->number,
            'district' => $address->district,
            'complement' => $address->complement,
            'city' => $address->city,
            'state' => $address->state,
            'country' => $address->country,
        ];
    }
}

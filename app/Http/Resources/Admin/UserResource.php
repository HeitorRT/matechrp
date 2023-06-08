<?php

namespace App\Http\Resources\Admin;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var User */
        $user = $this->resource;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'active' => $user->active,
            'cpf' => $user->cpf,
            'phone' => $user->phone,
            'address'  => $user->address,
            'whereby_link' => $user->whereby_link,
            'is_system_user' => $user->is_system_user,
            'is_teacher' => $user->is_teacher,
            'is_partner' => $user->is_partner,

            /** Relations */
            'roles' => RoleResource::collection($user->roles),
            'role_ids' => $user->role_ids,
            'address'  => new AddressResource($user->address),
        ];
    }
}

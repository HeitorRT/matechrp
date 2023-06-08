<?php

namespace App\Http\Resources\Student;

use App\Models\Student;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Student */
        $student = $this->resource;

        return [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'profile_image'  => $student->profile_image,
            'created_at'  => $student->created_at,
        ];
    }



}

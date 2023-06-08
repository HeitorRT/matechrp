<?php

namespace App\Http\Resources\Admin;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Category */
        $category = $this->resource;

        return [
            'id' => $category->id,
            'name' => $category->name,
            'is_permanent' => $category->is_permanent
        ];
    }
}

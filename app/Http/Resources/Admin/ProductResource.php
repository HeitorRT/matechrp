<?php

namespace App\Http\Resources\Admin;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        /** @var Product */
        $product = $this->resource;

        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'url_sale' => $product->url_sale,
            'terms_acceptance' => $product->terms_acceptance,
            'image' => $product->image,
            'video_url' => $product->video_url,
            'credit_card_accept' => $product->credit_card_accept,
            'credit_card_value' => $product->credit_card_value,
            'credit_card_installments' => $product->credit_card_installments,
            'boleto_accept' => $product->boleto_accept,
            'boleto_value' => $product->boleto_value,
            'boleto_installments' => $product->boleto_installments,
            'pix_accept' => $product->pix_accept,
            'pix_value' => $product->pix_value,
            'checkout_code' => $product->checkout_code,
            'checkout_link' => $product->checkout_link,
        ];
    }
}

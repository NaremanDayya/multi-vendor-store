<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => [
                'normal' => $this->price,
                'compare' => $this->compare_price,
            ],
            'image' => $this->image_url,
            'relations' => [
                'category' => [
                    'id' => $this->category_id,
                    'name' => $this->category->name,
                ],
                'store' => [
                    'id' => $this->store->id,
                    'name' => $this->store->name,
                ],

            ],
        ];
    }
}

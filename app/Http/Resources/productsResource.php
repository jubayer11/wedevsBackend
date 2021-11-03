<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class productsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'uniqueId' => $this->uniqueId,
            'image' => $this->image,
            'description' => $this->description,
        ];
    }
}
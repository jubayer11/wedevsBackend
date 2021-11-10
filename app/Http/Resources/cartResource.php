<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class cartResource extends JsonResource
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
            'id' => $this->pivot->id,
            'productId' => $this->pivot->productId,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'customerQuantity' => $this->pivot->quantity,
            'image' => $this->image,
            'selectedQuantity' => 0,
            'increment' => false,
            'decrement' => false,
        ];
    }
}

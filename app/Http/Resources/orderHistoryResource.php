<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class orderHistoryResource extends JsonResource
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
            'method' => $this->description,
            'productName' => $this->properties->attributes->{'orderProduct.name'},
            'productImage' => $this->properties->attributes->{'orderProduct.image'},
            'newQuantity'=>$this->properties->attributes->quantity,
            'oldQuantity'=> $this->when($this->description == 'updated', function () {
                return $this->properties->old->quantity;
            }),
            'createdAt' =>\Carbon\Carbon::parse($this->created_at)->diffForHumans(),

        ];
    }
}

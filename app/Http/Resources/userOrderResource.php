<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class userOrderResource extends JsonResource
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
            'id' => $this->id,
            'billingAddress' => $this->billingAddress,
            'status' => $this->status,
            'createdAt' => $this->created_at->diffForHumans(),
            'userName' => $this->users->name,
        ];
    }
}

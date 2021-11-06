<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class usersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'isStaff' => $this->isStaff,
            'role' => $this->role,
            'createdAt' => $this->created_at->diffForHumans(),
            ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopRateResource extends JsonResource
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
            'user' => new UserResource($this->user),
            'rate' => $this->rate,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'created_at_formatted' => $this->created_at->diffForHumans(),
        ];
    }
}

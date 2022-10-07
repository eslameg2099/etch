<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DelegateRateResource extends JsonResource
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
            'user' => new UserResource($this->User),
            'rate' => $this->entityRate->rate,
            'comment' => $this->entityRate->comment,
            'created_at' => $this->entityRate->created_at,
            'created_at_formatted' => $this->entityRate->created_at->diffForHumans(),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminNotificationResource extends JsonResource
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
            "label" => $this->label,
            "body" => $this->body,
            "image" => $this->getFirstMediaUrl(),
            'type' => $this->user_type
        ];
    }
}

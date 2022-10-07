<?php

namespace App\Http\Resources\Delegates;

use Illuminate\Http\Resources\Json\JsonResource;

class MiniDelegateResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'rate' => $this->when($this->isDelegate(), function () {
                return (string)  $this->delegateOrders()->has('entityRate')->avg('rate');
            }),
            'image_url' => $this->getFirstMediaUrl(),
        ];
    }
}

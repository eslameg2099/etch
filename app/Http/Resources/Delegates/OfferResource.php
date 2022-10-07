<?php

namespace App\Http\Resources\Delegates;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'offer_id'          =>  $this->id,
            'status'            =>  $this->status,
            'readable_status'   =>  $this->readable_status,
            //'delegate'          =>  $this->delegate->only('id', 'name', 'mobile', 'rate', 'image_url'),
            'delegate'          =>  new MiniDelegateResource($this->delegate),
            'distance'          =>  number_format($this->distance, 2) .' Km',
        ];
    }
}

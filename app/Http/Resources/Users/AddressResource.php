<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\MasterData\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'address'       =>  $this->address,
            'lat'           =>  floatval($this->lat),
            'long'          =>  floatval($this->lng),
            'city'          =>  new CityResource($this->city),
            'is_default'    =>  $this->is_default
        ];
    }
}

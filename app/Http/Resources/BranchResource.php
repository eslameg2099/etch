<?php

namespace App\Http\Resources;

use App\Http\Resources\MasterData\CategoryResource;
use App\Http\Resources\MasterData\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Shop */
class BranchResource extends JsonResource
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
            'id'        =>  $this->id,
            'name'      =>  $this->name,
            'city'      =>  new CityResource($this->city),
            'description'   =>  $this->description,
            'lat'       =>  $this->lat,
            'long'      =>  $this->lng,
            'address'      =>  $this->address,
            'distance'  =>  $this->when(isset($this->distance) , number_format($this->distance , 2).' Km'),
        ];
    }
}

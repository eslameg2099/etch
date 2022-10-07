<?php

namespace App\Http\Resources;

use App\Http\Resources\MasterData\CategoryResource;
use App\Http\Resources\MasterData\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->branch) return $this->branchDemand();
        return [
            'id'        =>  $this->id,
            'name'      =>  $this->name,
            'category'  =>  new CategoryResource($this->category),
            //'city'      =>  new CityResource($this->city),
            'city'      =>  isset($this->branch) ? new CityResource($this->branch->city) : $this->city,
            'rate'      =>  (string) $this->rate,
            'open_at'   =>  (string) $this->open_at,
            'closed_at' =>  (string) $this->closed_at,
            'description'   =>  $this->description,
            'lat'       =>  $this->lat,
            'long'      =>  $this->lng,
            'address'      =>  isset($this->branch) ?  $this->branch->address : $this->address,
            'image'     =>  $this->getFirstMediaUrl(),
            'menu_images'    =>  $this->getMedia('menu')->map->getUrl(),
            'distance'  =>  $this->when(isset($this->distance) , number_format($this->distance , 2).' Km'),
            'menu'  =>  $this->getMedia('menu')->map->getUrl(),
            'is_favorite'  =>  $this->isFavorited(),
        ];
    }

    private function branchDemand()
    {
        return [
            'id'        =>  $this->id,
            'name'      =>  $this->name,
            'category'  =>  new CategoryResource($this->category),
            //'city'      =>  new CityResource($this->city),
            'city'      =>  isset($this->branch) ? new CityResource($this->branch->city) : $this->city,
            'rate'      =>  (string) $this->rate,
            'open_at'   =>  (string) $this->open_at,
            'closed_at' =>  (string) $this->closed_at,
            'description'   =>  $this->description,
            'lat'       =>  $this->branch->lat,
            'long'      =>  $this->branch->lng,
            //'address'      =>  isset($this->branch) ?  $this->branch->address : $this->address,
            'address'      =>  $this->branch->address,
            'image'     =>  $this->getFirstMediaUrl(),
            'menu_images'    =>  $this->getMedia('menu')->map->getUrl(),
            'distance'  =>  $this->when(isset($this->distance) , number_format($this->distance,2).' Km'),
            //'distance'  =>  $this->distance,
            'menu'  =>  $this->getMedia('menu')->map->getUrl(),
            'is_favorite'  =>  $this->isFavorited(),
        ];
    }
}

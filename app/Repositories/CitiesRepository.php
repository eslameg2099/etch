<?php


namespace App\Repositories;


use App\Http\Resources\MasterData\CityResource;
use App\Interfaces\CitiesRepositoryInterface;
use App\Models\MasterData\City;
use App\Traits\RepositoryResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitiesRepository implements CitiesRepositoryInterface
{
    use RepositoryResponseTrait;

    public function getCities()
    {
        return \request()->wantsJson()
            ? CityResource::collection(City::query()->get())
            : City::query()->paginate();
    }

    public function getCity($id)
    {
        $city   =   City::query()->find($id);
        return \request()->wantsJson()
            ? ( $city ? new CityResource($city) : $this->error(['message' => trans('errors.city_not_found')]) )
            : ( $city ? $city : $this->error(['message' => trans('errors.city_not_found')]) );
    }

    public function storeOrUpdateCity(Request $request, $id = null)
    {
        // TODO: Implement storeOrUpdateCity() method.
    }

    public function deleteCity($id)
    {
        // TODO: Implement deleteCity() method.
    }
}

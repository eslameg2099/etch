<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DelegateRateResource;
use App\Http\Resources\MasterData\CategoryResource;
use App\Http\Resources\ShopResource;
use App\Http\Resources\SliderResource;
use App\Interfaces\CategoriesRepositoryInterface;
use App\Interfaces\ShopsRepositoryInterface;
use App\Models\MasterData\Category;
use App\Models\Shop;
use App\Models\Slider;
use App\Models\Users\User;
use App\Traits\RepositoryResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RateController extends Controller
{
    use RepositoryResponseTrait;

    /**
     * Rate the given shop.
     *
     * @param \App\Models\Users\User $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function delegate(User $user)
    {
        $rates = $user->delegateOrders()->has('entityRate')->with('entityRate')->simplePaginate();

        return DelegateRateResource::collection($rates);
    }
}

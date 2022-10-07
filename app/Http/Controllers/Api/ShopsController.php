<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterData\CategoryResource;
use App\Http\Resources\ShopRateResource;
use App\Http\Resources\ShopResource;
use App\Http\Resources\SliderResource;
use App\Interfaces\CategoriesRepositoryInterface;
use App\Interfaces\ShopsRepositoryInterface;
use App\Models\Branch;
use App\Models\MasterData\Category;
use App\Models\Shop;
use App\Models\Slider;
use App\Traits\RepositoryResponseTrait;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Laraeast\LaravelSettings\Facades\Settings;

class ShopsController extends Controller
{
    use RepositoryResponseTrait;

    private $shopsRepo;

    public function __construct(ShopsRepositoryInterface $shopsRepo)
    {
        $this->shopsRepo = $shopsRepo;
    }
    private function shops_distance()
    {
        $shops = Branch::filter()->withDistance()->get()->unique("shop_id")->map(function ($branch){
            $shop = $branch->shop;
            $shop->distance = $branch->distance;
            $shop->branch = $branch;
            return $shop;
        });
        return $shops->whereNull('deleted_at');
    }
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        //$currentPage = $page;
        //$total = $items->count();
        //return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
        //    'items', 'total', 'perPage', 'currentPage', 'options'
        //));
    }
    public function index()
    {
        $shops = $this->shops_distance();
        return ShopResource::collection($this->paginate($shops, 10, request('page'), ['path' => request()->fullUrl()]));
        //return ShopResource::collection($shops);
    }
    public function bla()
    {
       $shops = Shop::all();
       foreach ($shops as $shop)
       {
           if(is_null($shop->city_id)) continue;
           Branch::create([
            'name' => $shop->name,
            'shop_id' => $shop->id,
            'city_id' => $shop->city_id,
            'lat' => $shop->lat,
            'lng' => $shop->lng,
            'address' => $shop->address,
           ]);
       }
        return ShopResource::collection($shops);
    }

    public function home()
    {
        $slider = Slider::all();
        $categories = Category::query()->get();
        //$nearShops = Shop::query()->Closest()->get()->take(3);
        //$nearShops = Branch::withDistance()->with('shop')->get()->take(3)->map(function ($branch){
        //    $shop = $branch->shop;
        //    $shop->distance = $branch->distance;
        //    $shop->branch = $branch;
        //    return $shop;
        //});
        //$nearShops = $nearShops->whereNull('deleted_at')->unique();
        $nearShops = $this->shops_distance()->take(3);
        return $this->success([
            'slider' => Settings::instance('slider') ? Settings::instance('slider')->getMedia('slider')->map->getUrl() : [],
            'offers' => Settings::instance('offers') ? Settings::instance('offers')->getMedia('offers')->map->getUrl() : [],
            'categories' => CategoryResource::collection($categories),
            'nearShops' => ShopResource::collection($nearShops),
        ]);
    }

    public function show($id)
    {
        $shop = $this->shopsRepo->getShopById($id);

        if (! $shop) {
            $this->error(['message' => trans('errors.cannot_find_this_shop')]);
        }

        return $this->success(['shop' => new ShopResource($shop)]);
    }

    /**
     * Rate the given shop.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function rate(Request $request, Shop $shop)
    {
        $request->validate([
            'rate' => 'required|numeric|between:1,5',
            'comment' => 'required|string',
        ]);

        $shop->rates()->updateOrCreate([
            'user_id' => auth()->id(),
        ], [
            'user_id' => auth()->id(),
            'rate' => $request->input('rate'),
            'comment' => $request->input('comment'),
        ]);

        return response()->json(['message' => __('Rated.')]);
    }

    /**
     * Get all the shop rates.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function rates(Shop $shop)
    {
        $rates = $shop->rates()->simplePaginate();

        return ShopRateResource::collection($rates);
    }

    public function favorite(Shop $shop)
    {
        $shop->toggleFavorite();

        return new ShopResource($shop->refresh());
    }
}

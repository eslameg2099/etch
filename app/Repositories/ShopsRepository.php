<?php


namespace App\Repositories;


use App\Interfaces\ShopsRepositoryInterface;
use App\Models\Shop;

class ShopsRepository implements ShopsRepositoryInterface
{

    public function getAllShops()
    {
        // TODO: Implement getAllShops() method.
    }

    public function getShopById($shop_id)
    {
        return Shop::query()->find($shop_id);
    }

    public function storeOrUpdateShop($request, $id)
    {
        // TODO: Implement storeOrUpdateShop() method.
    }

    public function destroy($shop_id)
    {
        // TODO: Implement destroy() method.
    }
}

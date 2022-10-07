<?php


namespace App\Interfaces;


interface ShopsRepositoryInterface
{
    public function getAllShops();

    public function getShopById($shop_id);

    public function storeOrUpdateShop($request, $id);

    public function destroy($shop_id);
}

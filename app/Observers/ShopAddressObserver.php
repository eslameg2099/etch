<?php

namespace App\Observers;

use App\Models\Shop;

class ShopAddressObserver
{
    /**
     * Handle the Shop "saved" event.
     *
     * @param \App\Models\Shop $shop
     * @return void
     */
    public function saved(Shop $shop)
    {
        Shop::withoutEvents(function () use ($shop) {
            $address = $this->saveAddressFromGoogleApis($shop);

            $shop->forceFill(['address' => $address])->save();
        });
    }

    /**
     * @param \App\Models\Shop $shop
     * @return string|void
     */
    public function saveAddressFromGoogleApis(Shop $shop)
    {
        $lat = $shop->lat;
        $lng = $shop->lng;

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=';
        $url .= trim($lat).','.trim($lng).'&key='.config('services.maps.key');
        $json = @file_get_contents($url);
        if ($json) {
            $data = json_decode($json);
            $status = $data->status;
            if ($status == "OK") {
                return $data->results[0]->formatted_address;
            }
        }
    }
}

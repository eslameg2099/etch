<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

if (! function_exists('distanceTwoPoint')) {
    function distanceTwoPoint($lat1, $lon1, $lat2, $lon2)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;
        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return $km;
    }
}

if (! function_exists('settingTable')) {
    function settingTable($key, $fail = null)
    {
        $setting = Cache::get('settings') ?: \App\Models\Setting::all();

        $value = optional(Cache::get('settings', function () use ($setting) {
            return $setting;
        })->where('key', $key)->first())->value;

        return $value ? $value : $fail;
    }
}

if (! function_exists('price')) {
    /**
     * Display the given price with currency.
     *
     * @param $price
     * @return string
     */
    function price($price)
    {
        return $price.' '. Settings::locale()->get('currency');
    }
}

if (! function_exists('delivery_distance')) {
    /**
     * return the delivery cost.
     *
     * @param $origin , $destination
     * @return string
     */
    function delivery_distance($origin , $destination)
    {
        $distance = 0;
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins' => $origin->lat .','. $origin->lng,
            'destinations' => 'side_of_road:'.$destination->lat.','.$destination->lng,
            'key' => config('services.google_matrix'),
        ]);
        $directions = collect($response->json());
        if (isset($directions['error_message'])) throw ValidationException::withMessages(["message" => "cannot decide location."]);
        $direction_element = $directions['rows'][0]['elements'][0];
        if($direction_element["status"] == "OK"){
            $distance = $direction_element["distance"]["value"] / 1000 ;
        }
        return ceil($distance);
    }
    if( !function_exists('getDir')) {
        function getDir() {
            return app()->getLocale() == 'ar' ? 'rtl' : 'ltr';
        }
    }
    if( !function_exists('getAddress')) {
        function getAddress($lng,$lat) {
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?language=ar&latlng=';
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

}
<?php

namespace Database\Seeders;

use App\Models\MasterData\City;
use Illuminate\Database\Seeder;

class CitiesTableSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::query()->truncate();

        City::query()->create([
            'id'            =>  1,
            'name:ar'       =>  'الرياض',
            'name:en'       =>  'AlRiadh',
            'country_id'    =>  1,
            'delivery_cost'    =>  30,
            'purchase_delivery_cost'    =>  30,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\MasterData\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory([
            'name:ar' => 'السعودية',
            'name:en' => 'Saudi',
        ])->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::factory()->create(['code' => 123]);
        Coupon::factory()->create(['code' => 456]);
        Coupon::factory()->create(['code' => 789]);
    }
}

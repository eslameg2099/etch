<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Laraeast\LaravelSettings\Facades\Settings;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slider = Settings::set('category_slider');

        $slider->addMedia(__DIR__.'/../images/slider/01.jpg')->preservingOriginal()->toMediaCollection('categories');
        $slider->addMedia(__DIR__.'/../images/slider/02.jpg')->preservingOriginal()->toMediaCollection('categories');
        $slider->addMedia(__DIR__.'/../images/slider/03.jpg')->preservingOriginal()->toMediaCollection('categories');

        //$slider = Slider::forceCreate([
        //    'type' => Slider::SLIDER_TYPE,
        //]);
        //
        //$slider->addMedia(__DIR__.'/../images/BAN01.png')->preservingOriginal()->toMediaCollection();
        //$slider->addMedia(__DIR__.'/../images/BAN02.png')->preservingOriginal()->toMediaCollection();
        //$slider = Slider::forceCreate([
        //    'type' => Slider::OFFER_TYPE,
        //]);
        //$slider->addMedia(__DIR__.'/../images/BAN03.png')->preservingOriginal()->toMediaCollection();

        Shop::query()->truncate();

        Shop::create([
            'name' => 'متجر 1',
            'category_id' => 1,
            'city_id' => 1,
            'rate' => 2.5,
            'open_at' => Carbon::now()->startOfDay()->toTimeString(),
            'closed_at' => Carbon::now()->endOfDay()->toTimeString(),
            'description' => 'متجر 1',
            'lat' => '31.240035',
            'lng' => '29.959469',
            'address' => 'Test Address',
        ]);
        Shop::create([
            'name' => 'متجر 2',
            'category_id' => 1,
            'city_id' => 1,
            'rate' => 2.5,
            'open_at' => Carbon::now()->startOfDay()->toTimeString(),
            'closed_at' => Carbon::now()->endOfDay()->toTimeString(),
            'description' => 'متجر 2',
            'lat' => '31.248918',
            'lng' => '29.973267',
            'address' => 'Test Address',
        ]);

        Shop::all()->each(function (Shop $shop) {
            $shop->addMedia(__DIR__.'/../images/menus/01.jpg')->preservingOriginal()->toMediaCollection('menu');
            $shop->addMedia(__DIR__.'/../images/menus/02.jpg')->preservingOriginal()->toMediaCollection('menu');
        });
    }
}

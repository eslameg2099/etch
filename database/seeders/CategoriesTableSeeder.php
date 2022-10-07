<?php

namespace Database\Seeders;

use App\Models\MasterData\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::query()->truncate();

        Category::create(['name' => 'ادوات كهربائية']);
        Category::create(['name' => 'مطاعم']);
        Category::create(['name' => 'سوبر ماركت']);
        Category::create(['name' => 'ملابس اطفال']);
        Category::create(['name' => 'متجر احذية']);
        Category::create(['name' => 'ملابس رجالي']);

    }
}

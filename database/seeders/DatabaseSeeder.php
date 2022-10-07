<?php

namespace Database\Seeders;

use App\Models\Users\Admin;
use App\Models\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->call('media-library:clean');

        Schema::disableForeignKeyConstraints();

        // \App\Models\User::factory(10)->create();
        $this->call(SettingSeeder::class);
        $this->call(CountriesTableSedder::class);
        $this->call(CitiesTableSedder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(TransactionsSeeder::class);

        Schema::enableForeignKeyConstraints();

        $users = User::get()->map(function ($user) {

            $type = $user->type == User::Delegate ? 'Delegate' : 'User';

            return [
                $user->id,
                $user->name,
                $user->mobile,
                '123456',
                $type,
                $user->type,
            ];
        });

        $admin = Admin::first();

        $users->prepend([$admin->id, $admin->name, $admin->mobile, '123456', 'Admin', $admin->type]);

        $this->command->table(['ID', 'Name', 'Mobile', 'Password', 'Type', 'Type Code'], $users->toArray());
    }
}

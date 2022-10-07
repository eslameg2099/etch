<?php

namespace Database\Seeders;

use App\Models\Users\Address;
use App\Models\Users\Admin;
use App\Models\Users\User;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::query()->truncate();

        Admin::query()->create([
            'name' => 'admin',
            'mobile' => '512345678',
            'password' => bcrypt(123456),
            'city_id' => 1,
        ]);

        $delegate = User::forceCreate([
            'name' => 'Sayed Delegate',
            'mobile' => '551111111',
            'password' => bcrypt(123456),
            'city_id' => 1,
            'is_active' => 1,
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'type' => User::Delegate,
            'lat' => '31.2745692',
            'lng' => '30.0020644',
        ]);
        $delegate->delegate()->create([
            'user_id' => $delegate->id,
            'national_id' => 'test',
            'vehicle_type' => 'test',
            'vehicle_model' => '1234',
            'vehicle_number' => '1234',
            'is_approved' => 1,
            'national_id_front_image' => '',
            'national_id_back_image' => '',
            'vehicle_number_image' => '',
        ]);

        $delegate->delegateLocations()->create([
            'lat' => '31.2745692',
            'lng' => '30.0020644',
            'order_id' => null,
        ]);

        $user = User::forceCreate([
            'name' => 'Sayed User',
            'mobile' => '552222222',
            'password' => bcrypt(123456),
            'city_id' => 1,
            'is_active' => 1,
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'type' => User::User,
        ]);

        Address::forceCreate([
            'user_id' => $user->id,
            'city_id' => 1,
            'name' => 'Home',
            'address' => 'Almandarah',
            'lat' => '31.2818747',
            'lng' => '30.0119187',
            'is_default' => 1,
        ]);
        Address::forceCreate([
            'user_id' => $user->id,
            'city_id' => 1,
            'name' => 'Work',
            'address' => 'Loran',
            'lat' => '31.2771585',
            'lng' => '30.0092806',
            'is_default' => 1,
        ]);
        ##############
        $delegate = User::forceCreate([
            'name' => 'Abd Elhamed Delegate',
            'mobile' => '553333333',
            'password' => bcrypt(123456),
            'city_id' => 1,
            'is_active' => 1,
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'type' => User::Delegate,
            'lat' => '31.2745692',
            'lng' => '30.0020644',
        ]);
        $delegate->delegate()->create([
            'user_id' => $delegate->id,
            'national_id' => 'test',
            'vehicle_type' => 'test',
            'vehicle_model' => '1234',
            'vehicle_number' => '1234',
            'is_approved' => 1,
            'national_id_front_image' => '',
            'national_id_back_image' => '',
            'vehicle_number_image' => '',
        ]);

        $delegate->delegateLocations()->create([
            'lat' => '31.2745692',
            'lng' => '30.0020644',
            'order_id' => null,
        ]);

        $user = User::forceCreate([
            'name' => 'Abd Elhamed User',
            'mobile' => '554444444',
            'password' => bcrypt(123456),
            'city_id' => 1,
            'is_active' => 1,
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'type' => User::User,
        ]);

        Address::forceCreate([
            'user_id' => $user->id,
            'city_id' => 1,
            'name' => 'Home',
            'address' => 'Almandarah',
            'lat' => '31.2818747',
            'lng' => '30.0119187',
            'is_default' => 1,
        ]);
        Address::forceCreate([
            'user_id' => $user->id,
            'city_id' => 1,
            'name' => 'Work',
            'address' => 'Loran',
            'lat' => '31.2771585',
            'lng' => '30.0092806',
            'is_default' => 1,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laraeast\LaravelSettings\Facades\Settings;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::set('currency:ar', 'ر.س');
        Settings::set('currency:en', 'SAR');
        Settings::set('mobile', '512345678');
        Settings::set('whatsapp', '512345678');
        Settings::set('email', 'support@fetch.com');
        Settings::set('telegram', '512345678');
        Settings::set('facebook', 'www.facebook.com');
        Settings::set('twitter', 'www.twitter.com');
        Settings::set('website', 'http://www.fetch-ksa.com');
        Settings::set('googleApp', 'apk');
        Settings::set('iosApp', 'ios');
        Settings::set('copyRights', 'copy Rights Content');
        Settings::set('aboutUs', 'aboutUs Content');
        Settings::set('usagePolicy', 'usagePolicy Content');
        Settings::set('termsAndConditions', 'termsAndConditions Content');
        Settings::set('privacyPolicy', 'privacyPolicy Content');
        Settings::set('blackList', 'blackList Content');
        Settings::set('canLoginWithSocial', '0');
        Settings::set('getDelegateLocationEverySec', 'getDelegateLocationEverySec');

        Settings::set('user_cancellation_grace_period', 5);
        Settings::set('user_cancellation_attempts', 5);
        Settings::set('delegate_cancellation_grace_period', 3);
        Settings::set('delegate_cancellation_attempts', 3);
        Settings::set('app_profits_percent', 25);
        Settings::set('delegate_hold_amount', 25);
        Settings::set('tax', 15);
        Settings::set('orders_per_day', 5);

        Settings::set('slider')->addMedia(__DIR__.'/../images/BAN01.png')->preservingOriginal()->toMediaCollection('slider');
        Settings::set('slider')->addMedia(__DIR__.'/../images/BAN02.png')->preservingOriginal()->toMediaCollection('slider');
        Settings::set('offers')->addMedia(__DIR__.'/../images/BAN03.png')->preservingOriginal()->toMediaCollection('offers');
    }
}

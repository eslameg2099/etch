<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::query()->truncate();

        Setting::query()->insert([
            [
                'key'   =>  'currency',
                'value' =>  json_encode(['ar'=>'ريال سعودي','en'=>'SAR']),
                'is_json'   =>  1,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'mobile',
                'value' =>  '512345678',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'whatsapp',
                'value' =>  '512345678',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],

            [
                'key'   =>  'email',
                'value' =>  'support@fetch.com',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'telegram',
                'value' =>  '512345678',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'facebook',
                'value' =>  'www.facebook.com',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'twitter',
                'value' =>  'www.twitter.com',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'website',
                'value' =>  'http://www.fetch.com',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'googleApp',
                'value' =>  'apk',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'iosApp',
                'value' =>  'ios',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'copyRights',
                'value' =>  'copy Rights Content',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'aboutUs',
                'value' =>  'aboutUs Content',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'usagePolicy',
                'value' =>  'usagePolicy Content',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'termsAndConditions',
                'value' =>  'termsAndConditions Content',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'privacyPolicy',
                'value' =>  'privacyPolicy Content',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'blackList',
                'value' =>  'blackList Content',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],
            [
                'key'   =>  'canLoginWithSocial',
                'value' =>  '0',
                'is_json'   =>  0,
                'is_shown'  =>  0,
            ],[
                'key'   =>  'getDelegateLocationEverySec',
                'value' =>  '30',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],[
                'key'   =>  'tax',
                'value' =>  '1',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ],[
                'key'   =>  'android_app_version',
                'value' =>  'android',
                'is_json'   =>  0,
                'is_shown'  =>  1,
            ]
        ]);
    }
}

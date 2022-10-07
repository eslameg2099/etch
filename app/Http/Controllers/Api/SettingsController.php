<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\MasterData\City;
use App\Models\Setting;
use Laraeast\LaravelSettings\Facades\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        /** @var City $city */
        $city = City::first();
        return response()->json([
            'app_profits_percent' => (float) Settings::get('app_profits_percent'),
            'delegate_hold_amount' => (float) Settings::get('delegate_hold_amount'),
            'tax' => Settings::get('tax'),
            'cash_payment' => (bool) Settings::get('cash_payment'),
            'wallet_payment' => (bool) Settings::get('wallet_payment'),
            'visa_payment' => (bool) Settings::get('visa_payment'),
            'android_app_version' => (int)Settings::get('android_app_version'),
            'delivery_cost' => $city->delivery_cost,
            'purchase_delivery_cost' => $city->purchase_delivery_cost,
        ]);
    }

    public function pagesAndContacts()
    {
        /** @var City $city */
        $city = City::first();
        return response()->json([
            'mobile' => Settings::get('mobile'),
            'whatsapp' => Settings::get('whatsapp'),
            'email' => Settings::get('email'),
            'telegram' => Settings::get('telegram'),
            'instagram' => Settings::get('instagram'),
            'twitter' => Settings::get('twitter'),
            'website' => Settings::get('website'),
            'googleApp' => Settings::get('googleApp'),
            'iosApp' => Settings::get('iosApp'),
            'copyRights' => Settings::get('copyRights'),
            'aboutUs' => Settings::get('aboutUs'),
            'usagePolicy' => Settings::get('usagePolicy'),
            'termsAndConditions' => Settings::get('termsAndConditions'),
            'privacyPolicy' => Settings::get('privacyPolicy'),
            'blackList' => Settings::get('blackList'),
            'canLoginWithSocial' => Settings::get('canLoginWithSocial'),
            'getDelegateLocationEverySec' => Settings::get('getDelegateLocationEverySec'),
            'cash_payment' => (bool) Settings::get('cash_payment'),
            'wallet_payment' => (bool) Settings::get('wallet_payment'),
            'visa_payment' => (bool) Settings::get('visa_payment'),
            'android_app_version' => Settings::get('android_app_version'),
            'delivery_cost' => $city->delivery_cost,
            'purchase_delivery_cost' => $city->purchase_delivery_cost,
        ]);
    }
    public function ad()
    {
        $ad = AdminNotification::where('active',1)->latest()->first();
        if(!$ad) return response()->json(["data" => null]);
        return response()->json([
            "data" => [
                'id' => $ad->id,
                'label' => $ad->label,
                'body' => $ad->body,
                'user_type' => $ad->user_type,
                'media' => empty($ad->getFirstMediaUrl()) ? null : $ad->getFirstMediaUrl(),
                'active' => !!  $ad->active,
            ]
        ]);
    }
}

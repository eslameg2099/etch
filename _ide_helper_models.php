<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Chat{
/**
 * App\Models\Chat\OrderChat
 *
 * @property int $id
 * @property int $order_id
 * @property int $can_replay
 * @property int $user_id
 * @property int $delegate_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users\User $delegate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat\OrderChatDetail[] $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat whereCanReplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat whereDelegateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChat whereUserId($value)
 */
	class OrderChat extends \Eloquent {}
}

namespace App\Models\Chat{
/**
 * App\Models\Chat\OrderChatDetail
 *
 * @property int $id
 * @property int $order_chat_id
 * @property int $sender_id
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Imageable[] $imagable
 * @property-read int|null $imagable_count
 * @property-read \App\Models\Users\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChatDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChatDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChatDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChatDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChatDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChatDetail whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChatDetail whereOrderChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChatDetail whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderChatDetail whereUpdatedAt($value)
 */
	class OrderChatDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ContactUs
 *
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs newQuery()
 * @method static \Illuminate\Database\Query\Builder|ContactUs onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ContactUs withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ContactUs withoutTrashed()
 */
	class ContactUs extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property string $code
 * @property int $percentage_value
 * @property int $usage_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon wherePercentageValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUsageCount($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Imageable
 *
 * @property int $id
 * @property int $imageable_id
 * @property string $imageable_type
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|Imageable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Imageable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Imageable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Imageable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imageable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imageable whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imageable whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imageable wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imageable whereUpdatedAt($value)
 */
	class Imageable extends \Eloquent {}
}

namespace App\Models\MasterData{
/**
 * App\Models\MasterData\Category
 *
 * @property int $id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop[] $shops
 * @property-read int|null $shops_count
 * @property-read \App\Models\Translations\CategoryTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Translations\CategoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 */
	class Category extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable, \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\MasterData{
/**
 * App\Models\MasterData\City
 *
 * @property int $id
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property float $delivery_cost
 * @property-read \App\Models\MasterData\Country $country
 * @property-read \App\Models\Translations\CityTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Translations\CityTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|City filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|City onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|City orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City translated()
 * @method static \Illuminate\Database\Eloquent\Builder|City translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDeliveryCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City withTranslation()
 * @method static \Illuminate\Database\Query\Builder|City withTrashed()
 * @method static \Illuminate\Database\Query\Builder|City withoutTrashed()
 */
	class City extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models\MasterData{
/**
 * App\Models\MasterData\Country
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MasterData\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \App\Models\Translations\CountryTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Translations\CountryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Country listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Country translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country withTranslation()
 */
	class Country extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models\MasterData{
/**
 * App\Models\MasterData\SmsLog
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $message
 * @property int|null $code
 * @property string|null $response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereUserId($value)
 */
	class SmsLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NewSetting
 *
 * @property int $id
 * @property string $key
 * @property string|null $locale
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|NewSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|NewSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewSetting whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewSetting whereValue($value)
 */
	class NewSetting extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Notification
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property int|null $user_id
 * @property int|null $order_id
 * @property int|null $offer_id
 * @property int|null $shop_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $notifiable
 * @property-read \App\Models\Orders\OrderOffer|null $offer
 * @property-read \App\Models\Orders\Order|null $order
 * @property-read \App\Models\Shop|null $shop
 * @property-read \App\Models\Users\User|null $user
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection|static[] all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseNotification read()
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseNotification unread()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $delegate_id
 * @property int|null $receiving_address_id
 * @property int $delivery_address_id
 * @property int $type
 * @property int $is_schedule
 * @property string|null $schedule_date
 * @property int|null $shop_id
 * @property int $status
 * @property string $reference_number
 * @property string $order_description
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property string|null $closed_at
 * @property float $rate
 * @property int $notified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $payment_type
 * @property-read \App\Models\Users\User|null $Delegate
 * @property-read \App\Models\Users\Address $DeliveryAddress
 * @property-read \App\Models\Users\Address|null $ReceivingAddress
 * @property-read \App\Models\Users\User $User
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat\OrderChat[] $chats
 * @property-read int|null $chats_count
 * @property-read \App\Models\Rate|null $entityRate
 * @property-read mixed $readable_status
 * @property-read mixed $readable_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Orders\OrderOffer[] $offers
 * @property-read int|null $offers_count
 * @property-read \App\Models\Orders\OrderPayment|null $payment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rate[] $rates
 * @property-read int|null $rates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \App\Models\Shop|null $shop
 * @method static \Illuminate\Database\Eloquent\Builder|Order deliveryChangeStatus()
 * @method static \Illuminate\Database\Eloquent\Builder|Order filter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Order filterableFilter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Order myOrders()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDelegateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceivingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereScheduleDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models\Orders{
/**
 * App\Models\Orders\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $delegate_id
 * @property int|null $receiving_address_id
 * @property int $delivery_address_id
 * @property int $type
 * @property int $is_schedule
 * @property string|null $schedule_date
 * @property int|null $shop_id
 * @property int $status
 * @property string $reference_number
 * @property string $order_description
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property string|null $closed_at
 * @property float $rate
 * @property int $notified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $payment_type
 * @property-read \App\Models\Users\User|null $Delegate
 * @property-read \App\Models\Users\Address $DeliveryAddress
 * @property-read \App\Models\Users\Address|null $ReceivingAddress
 * @property-read \App\Models\Users\User $User
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat\OrderChat[] $chats
 * @property-read int|null $chats_count
 * @property-read \App\Models\Rate|null $entityRate
 * @property-read mixed $readable_status
 * @property-read mixed $readable_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Orders\OrderOffer[] $offers
 * @property-read int|null $offers_count
 * @property-read \App\Models\Orders\OrderPayment|null $payment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rate[] $rates
 * @property-read int|null $rates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \App\Models\Shop|null $shop
 * @method static \Illuminate\Database\Eloquent\Builder|Order deliveryChangeStatus()
 * @method static \Illuminate\Database\Eloquent\Builder|Order filter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Order myOrders()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDelegateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceivingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereScheduleDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models\Orders{
/**
 * App\Models\Orders\OrderOffer
 *
 * @property int $id
 * @property int $order_id
 * @property int $delegate_id
 * @property string $lat
 * @property string $lng
 * @property string|null $accepted_at
 * @property int $status
 * @property string $distance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Users\User $delegate
 * @property-read mixed $long
 * @property-read mixed $readable_status
 * @property-read \App\Models\Orders\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer delegateCanWithdrawal()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer newDelegateOrders()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer newQuery()
 * @method static \Illuminate\Database\Query\Builder|OrderOffer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereDelegateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderOffer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OrderOffer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OrderOffer withoutTrashed()
 */
	class OrderOffer extends \Eloquent {}
}

namespace App\Models\Orders{
/**
 * App\Models\Orders\OrderPayment
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $payment_transaction_id
 * @property float $amount
 * @property int $status
 * @property int|null $coupon_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Orders\OrderPaymentDetails[] $details
 * @property-read int|null $details_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Orders\OrderPaymentDetails[] $itemsDetails
 * @property-read int|null $items_details_count
 * @property-read \App\Models\Orders\Order $order
 * @property-read \App\Models\PaymentTransaction|null $payment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Orders\OrderPaymentDetails[] $staticDetails
 * @property-read int|null $static_details_count
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment newQuery()
 * @method static \Illuminate\Database\Query\Builder|OrderPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment wherePaymentTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OrderPayment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OrderPayment withoutTrashed()
 */
	class OrderPayment extends \Eloquent {}
}

namespace App\Models\Orders{
/**
 * App\Models\Orders\OrderPaymentDetails
 *
 * @property int $id
 * @property int $order_payment_id
 * @property int $item_type
 * @property string $item_name
 * @property float $cost
 * @property float|null $discount
 * @property int|null $discount_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Orders\OrderPayment $orderPayment
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails newQuery()
 * @method static \Illuminate\Database\Query\Builder|OrderPaymentDetails onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereItemType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereOrderPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OrderPaymentDetails withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OrderPaymentDetails withoutTrashed()
 */
	class OrderPaymentDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentTransaction
 *
 * @property int $id
 * @property int $user_id
 * @property string $reference_code
 * @property float $amount
 * @property string $payment_response
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction newQuery()
 * @method static \Illuminate\Database\Query\Builder|PaymentTransaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction wherePaymentResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereReferenceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|PaymentTransaction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PaymentTransaction withoutTrashed()
 */
	class PaymentTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Rate
 *
 * @property int $id
 * @property int $user_id
 * @property string $ratable_type
 * @property int $ratable_id
 * @property float $rate
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $ratable
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereRatableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereRatableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereUserId($value)
 */
	class Rate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Report
 *
 * @property int $id
 * @property int $user_id
 * @property int $delegate_id
 * @property int $order_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users\User $delegate
 * @property-read \App\Models\Orders\Order $order
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDelegateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUserId($value)
 */
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property int $is_shown
 * @property int $is_json
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereIsJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereIsShown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shop
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $city_id
 * @property float $rate
 * @property string|null $open_at
 * @property string|null $closed_at
 * @property string|null $except_days
 * @property string $lat
 * @property string $lng
 * @property string|null $address
 * @property int|null $by_user
 * @property int $is_active
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\MasterData\Category|null $category
 * @property-read \App\Models\MasterData\City|null $city
 * @property-read \App\Models\Rate|null $entityRate
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Imageable[] $images
 * @property-read int|null $images_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rate[] $rates
 * @property-read int|null $rates_count
 * @property-read \App\Models\Translations\ShopTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Translations\ShopTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Shop closest()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Shop onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereExceptDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereOpenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop withDistance()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Shop withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Shop withoutTrashed()
 */
	class Shop extends \Eloquent implements \Spatie\MediaLibrary\HasMedia, \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string|null $url
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUrl($value)
 */
	class Slider extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\CategoryTranslation
 *
 * @property int $id
 * @property int $category_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereName($value)
 */
	class CategoryTranslation extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\CityTranslation
 *
 * @property int $id
 * @property int $city_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereName($value)
 */
	class CityTranslation extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\CountryTranslation
 *
 * @property int $id
 * @property int $country_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereName($value)
 */
	class CountryTranslation extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\ShopTranslation
 *
 * @property int $id
 * @property int $shop_id
 * @property string $locale
 * @property string|null $name
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation whereShopId($value)
 */
	class ShopTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserCredit
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $account_name
 * @property string|null $bank_name
 * @property string|null $account_number
 * @property string|null $iban_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit whereIbanNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCredit whereUserId($value)
 */
	class UserCredit extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\Address
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $city_id
 * @property string $name
 * @property string $address
 * @property string $lat
 * @property string $lng
 * @property int $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\MasterData\City|null $city
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Query\Builder|Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Address withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Address withoutTrashed()
 */
	class Address extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property int $city_id
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MasterData\City $city
 * @property-read mixed $image_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\Delegate
 *
 * @property int $id
 * @property int $user_id
 * @property string $national_id
 * @property string|null $national_id_front_image
 * @property string|null $national_id_back_image
 * @property string $vehicle_type
 * @property string $vehicle_model
 * @property string $vehicle_number
 * @property string|null $vehicle_number_image
 * @property int $is_available
 * @property int $is_approved
 * @property int $can_receive_cash_orders
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $national_id_back_image_url
 * @property-read mixed $national_id_front_image_url
 * @property-read mixed $vehicle_number_image_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate newQuery()
 * @method static \Illuminate\Database\Query\Builder|Delegate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereCanReceiveCashOrders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereNationalIdBackImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereNationalIdFrontImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereVehicleModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereVehicleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereVehicleNumberImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereVehicleType($value)
 * @method static \Illuminate\Database\Query\Builder|Delegate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Delegate withoutTrashed()
 */
	class Delegate extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\DelegateLocation
 *
 * @property int $id
 * @property int $delegate_id
 * @property string $lat
 * @property string $lng
 * @property int|null $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users\User $delegate
 * @property-read mixed $long
 * @property-read \App\Models\Orders\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation getClosest($lat, $lng)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation whereDelegateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateLocation whereUpdatedAt($value)
 */
	class DelegateLocation extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\DelegateRate
 *
 * @property-read \App\Models\Orders\Order $order
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $rateable
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateRate query()
 */
	class DelegateRate extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\User
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $city_id
 * @property string $mobile
 * @property string|null $email
 * @property string $password
 * @property int $is_active
 * @property float $rate
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $mobile_verified_at
 * @property int $orders_count
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $image
 * @property string|null $socket_status
 * @property int|null $cancellation_attempts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\MasterData\City $city
 * @property-read \App\Models\UserCredit|null $credit
 * @property-read \App\Models\Users\Delegate|null $delegate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\DelegateLocation[] $delegateLocations
 * @property-read int|null $delegate_locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Orders\Order[] $delegateOrders
 * @property-read int|null $delegate_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read mixed $image_url
 * @property-read mixed $number_with_code
 * @property-read mixed $readable_type
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\App\Models\Notification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rate[] $rates
 * @property-read int|null $rates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MasterData\SmsLog[] $sms
 * @property-read int|null $sms_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Support\Payment\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Support\Payment\Models\Transaction[] $transactionsForHumans
 * @property-read int|null $transactions_for_humans_count
 * @method static \Illuminate\Database\Eloquent\Builder|User closestDelegates($lat, $lng, $city_id, $lastUpdateByHour = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCancellationAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobileVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOrdersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSocketStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Support\Payment\Models{
/**
 * App\Support\Payment\Models\Checkout
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $checkout_id
 * @property string $transaction_identifier
 * @property string $amount
 * @property string $payment_type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Support\Payment\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\Users\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout pending()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout query()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout rejected()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout rejectedByExternalBank()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout successful()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout successfulAndPending()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereCheckoutId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereTransactionIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereUserId($value)
 */
	class Checkout extends \Eloquent {}
}

namespace App\Support\Payment\Models{
/**
 * App\Support\Payment\Models\Transaction
 *
 * @property int $id
 * @property int|null $parent_id Any transaction carrying the parent_id value is just for details and not charged
 * @property int|null $user_id
 * @property int|null $actor_id
 * @property string $identifier
 * @property int|null $checkout_id
 * @property string $amount
 * @property string $status
 * @property string $type
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $date
 * @property int|null $order_id
 * @property string|null $account_name In Withdrawal Case
 * @property string|null $bank_name In Withdrawal Case
 * @property string|null $account_number In Withdrawal Case
 * @property string|null $iban_number In Withdrawal Case
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users\User|null $actor
 * @property-read \App\Support\Payment\Models\Checkout|null $checkout
 * @property-read \Illuminate\Database\Eloquent\Collection|Transaction[] $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Orders\Order|null $order
 * @property-read Transaction|null $parent
 * @property-read \App\Models\Users\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction parentsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereActorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCheckoutId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereIbanNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
 */
	class Transaction extends \Eloquent implements \App\Support\Payment\Contracts\TransactionStatuses, \App\Support\Payment\Contracts\TransactionTypes {}
}


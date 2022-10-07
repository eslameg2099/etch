<?php

namespace App\Models\Users;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Http\Filters\Filterable;
use App\Http\Filters\UserFilter;
use App\Models\Collect;
use App\Models\Concerns\HasRates;
use App\Models\MasterData\City;
use App\Models\MasterData\SmsLog;
use App\Models\Membership;
use App\Models\Notification;
use App\Models\Orders\Order;
use App\Models\Report;
use App\Models\UserCredit;
use App\Support\Payment\Concerns\HasTransactions;
use Carbon\Carbon;
use ChristianKuri\LaravelFavorite\Traits\Favoriteability;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laraeast\LaravelSettings\Facades\Settings;
use Laravel\Sanctum\HasApiTokens;
use Malhal\Geographical\Geographical;
//use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory,
        Notifiable,
        SoftDeletes,
        HasApiTokens,
        HasRates,
        Favoriteability,
        HasTransactions,
        Filterable,
        InteractsWithMedia,
        HasUploader,
        Geographical,
        SoftDeletes;

    const LATITUDE = 'lat';

    const LONGITUDE = 'lng';

    protected static $kilometers = true;

    protected $guard = 'users';

    protected $table = 'users';

    protected $filter = UserFilter::class;

    protected $fillable = [
        'name',
        'city_id',
        'mobile',
        'type',
        'password',
        'is_active',
        'email_verified_at',
        'mobile_verified_at',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    public $pushNotificationType = 'users';

    protected $appends = ['number_with_code', 'image_url', 'readable_type'];

    const User = 1;

    const Delegate = 2;

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withTrashed();
    }

    public function delegateLocation()
    {
        return $this->hasOne(DelegateLocation::class, 'delegate_id', 'id');
    }

    public function delegateLocations()
    {
        return $this->hasMany(DelegateLocation::class, 'delegate_id', 'id');
    }

    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

    public function delegateOrders()
    {
        return $this->hasMany(Order::class, 'delegate_id', 'id');
    }

    public function delegateTodayCompletedOrders()
    {
        return $this->hasMany(Order::class, 'delegate_id', 'id')
            ->where('status', Order::Delivered)
            ->whereDate('created_at', today());
    }

    public function orderLastLocation($orderId)
    {
        $this->delegateLocations()->where('order_id', $orderId);
    }

    public function scopeClosestDelegates(Builder $query, $lat, $lng, $city_id, $lastUpdateByHour = null)
    {
        if (! $lat && ! $lng) {
            return $query;
        }

        return $query
            ->whereNotNull(['lat', 'lng'])
            ->where('city_id', $city_id)
            ->whereHas('delegate', function ($query) {
                $query->where('is_available', 1);
            })
            ->when($lastUpdateByHour, function (Builder $q) use ($lastUpdateByHour) {
                $q->whereHas('delegateLocations', function (Builder $builder) use ($lastUpdateByHour) {
                    $builder->where('updated_at', '>=', Carbon::now()->subHours($lastUpdateByHour));
                });
            })
            ->distance($lat, $lng)
            //->having('distance', '<=', 5)
            ->orderBy('distance');
    }

    public function delegate()
    {
        return $this->hasOne(Delegate::class, 'user_id', 'id');
    }

    public function sms()
    {
        return $this->hasMany(SmsLog::class, 'user_id', 'id');
    }

    /**
     * Get the user's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function lastVerificationCode()
    {
        return $this->sms()->latest()->where('type', SmsLog::VerifyCode)->first();
    }

    public function lastResetPasswordCode()
    {
        return $this->sms()->latest()->where('type', SmsLog::ResetPassword)->first();
    }

    public function lastChangePhoneNumberCode()
    {
        return $this->sms()->latest()->where('type', SmsLog::ChangePhoneNumber)->first();
    }

    public function getNumberWithCodeAttribute()
    {
        return "966$this->mobile";
    }

    public function isCustomer()
    {
        return auth()->user()->type == self::User;
    }

    public function isDelegate()
    {
        return $this->type == self::Delegate;
    }

    public function getReadableTypeAttribute()
    {
        if (isset($this->type))
        {
            return [
                self::User => trans('global.user'),
                self::Delegate => trans('global.delegate'),
            ][$this->type];
        }
        return [
            self::User => trans('global.user'),
            self::Delegate => trans('global.delegate'),
        ];
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : asset('assets/images/ic_splash_logo.png');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function canUndo(Order $order)
    {
        $date = $order->created_at;

        if ($order->start_at) {
            $date = $order->start_at;
        }

        $cancellationGracePeriod = $this->getCancellationGracePeriod();

        return ! $date->addMinutes($cancellationGracePeriod)->isPast();
    }

    /**
     * @return mixed
     */
    public function getCancellationGracePeriod()
    {
        return $this->isDelegate()
            ? Settings::get('delegate_cancellation_grace_period', 3)
            : Settings::get('user_cancellation_grace_period', 5);
    }

    /**
     * Get the notification routing information for the pusher push notifications driver.
     *
     * @return string
     */
    public function routeNotificationForPusherPushNotifications()
    {
        return $this->id;
    }

    public function credit()
    {
        return $this->hasOne(UserCredit::class, 'user_id');
    }

    /**
     * Make the given, typically visible, attributes fillable.
     *
     * @param array|string|null $attributes
     * @return $this
     */
    public function makeFillable($attributes)
    {
        $this->fillable = array_merge(
            $this->fillable, is_array($attributes) ? $attributes : func_get_args()
        );

        return $this;
    }
    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->useFallbackUrl('https://www.gravatar.com/avatar/'.md5($this->email).'?d=mm')
            ->singleFile();
        $this->addMediaCollection('national_id_front_image')->singleFile();
        $this->addMediaCollection('national_id_back_image')->singleFile();
        $this->addMediaCollection('vehicle_number_image')->singleFile();
    }

    /**
     * @return mixed|void
     */
    public function getDelegateMembership()
    {
        $memberships = Membership::latest('rates_count')->get();

        $ratesCount = $this->delegateOrders()->whereHas('entityRate', function ($q) {
            return $q->where('rate', 5);
        })->count();

        foreach ($memberships as $membership) {
            if ($membership->rates_count <= $ratesCount) {
                return $membership;
            }
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function withdrawals()
    {
        return $this->belongsToMany(Order::class, 'order_withdrawal', 'delegate_id', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collects()
    {
        return $this->hasMany(Collect::class);
    }
}

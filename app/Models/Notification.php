<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Models\Users\User;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use App\Support\Payment\Models\Transaction;
use Illuminate\Notifications\DatabaseNotification;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Notification extends DatabaseNotification implements HasMedia
{
    use InteractsWithMedia;
    use HasUploader;
    /**
     * @var int
     */
    const DELIVERED_ORDER_TYPE = 1;

    /**
     * @var int
     */
    const PURCHASE_ORDER_TYPE = 2;

    /**
     * @var int
     */
    const SCHEDULE_DELIVERED_ORDER_TYPE = 3;

    /**
     * @var int
     */
    const SCHEDULE_PURCHASE_ORDER_TYPE = 4;

    /**
     * @var int
     */
    const RATE_ORDER_TYPE = 5;

    /**
     * @var int
     */
    const RATE_SHOP_TYPE = 6;

    /**
     * @var int
     */
    const DELEGATE_TYPE = 7;

    /**
     * @var int
     */
    const WALLET_TYPE = 8;

    /**
     * @var int
     */
    const CANCELLATION_ATTEMPTS_TYPE = 9;

    /**
     * @var int
     */
    const CHAT_MESSAGE_TYPE = 10;
    /**
     * @var int
     */
    const ADMIN_TYPE = 11;
 /**
     * @var int
     */
    const INTERIOR_TYPE = 12;

    /**
     * Get the user that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * Get the order that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the offer that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function offer()
    {
        return $this->belongsTo(OrderOffer::class, 'offer_id');
    }

    /**
     * Get the shop that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    /**
     * Get the transaction that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}

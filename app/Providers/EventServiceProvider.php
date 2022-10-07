<?php

namespace App\Providers;

use App\Models\Shop;
use App\Models\Users\Delegate;
use App\Models\Users\User;
use App\Models\Orders\Order;
use App\Observers\ApproveDelegateObserver;
use App\Observers\CancellationAttemptsObserver;
use App\Observers\RejectOffersWhenCancelOrderObserver;
use App\Observers\ShopAddressObserver;
use App\Observers\UserObserver;
use App\Observers\OrdersObserver;
use Illuminate\Auth\Events\Registered;
use App\Support\Payment\Models\Transaction;
use App\Observers\UpdateDelegateRateObserver;
use App\Observers\DisableReceivingCashOrdersIfBalanceNotEnough;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\Reported::class => [
            \App\Listeners\SendReportedNotification::class,
        ],
        \App\Events\NewOrderOfferEvent::class => [
            \App\Listeners\NewOrderOfferListener::class,
        ],
        \App\Events\CustomerAcceptOfferEvent::class => [
            \App\Listeners\CustomerAcceptOfferListener::class,
        ],
        \App\Events\CustomerChangeDelegateEvent::class => [
            \App\Listeners\CustomerChangeDelegateListener::class,
        ],
        \App\Events\CustomerCancelOrderEvent::class => [
            \App\Listeners\CustomerCancelOrderListener::class,
        ],
        \App\Events\CustomerPayOrderEvent::class => [
            \App\Listeners\CustomerPayOrderListener::class,
        ],
        \App\Events\DelegateWithdrawalEvent::class => [
            \App\Listeners\DelegateWithdrawalListener::class,
        ],
        \App\Events\NewScheduleOrderEvent::class => [
            \App\Listeners\ScheduleOrderListener::class,
        ],
        \App\Events\UpdateOrderStatusEvent::class => [
            \App\Listeners\UpdateOrderStatusListener::class,
        ],
        \App\Events\RateOrderEvent::class => [
            \App\Listeners\RateOrderListener::class,
        ],
        \App\Events\RateShopEvent::class => [
            \App\Listeners\RateShopListener::class,
        ],
        \App\Events\DelegateAddInvoiceEvent::class => [
            \App\Listeners\DelegateAddInvoiceListener::class,
        ],
        \App\Events\WalletRechargeEvent::class => [
            \App\Listeners\WalletRechargeListener::class,
        ],
        \App\Events\WalletWithdrawalEvent::class => [
            \App\Listeners\WalletWithdrawalListener::class,
        ],
        \App\Events\WalletWithdrawalDoneEvent::class => [
            \App\Listeners\WalletWithdrawalDoneListener::class,
        ],
        \App\Events\DelegateApprovedEvent::class => [
            \App\Listeners\DelegateApprovedListener::class,
        ],
        \App\Events\DelegateDeclinedEvent::class => [
            \App\Listeners\DelegateDeclinedListener::class,
        ],
        \App\Events\NewOrderChatMessageEvent::class => [
            \App\Listeners\NewOrderChatMessageListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrdersObserver::class);
        Order::observe(UpdateDelegateRateObserver::class);
        Order::observe(RejectOffersWhenCancelOrderObserver::class);
        User::observe(UserObserver::class);
        User::observe(CancellationAttemptsObserver::class);
        Transaction::observe(DisableReceivingCashOrdersIfBalanceNotEnough::class);
        Delegate::observe(ApproveDelegateObserver::class);
        Shop::observe(ShopAddressObserver::class);
    }
}

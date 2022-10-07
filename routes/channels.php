<?php

use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('interior-notification-{type}', function ($user, $type) {
    return (int) $user->type === (int) $type;
});
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user-{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('order-{order_reference}', function ($user, $orderReference) {

    $order = Order::where('reference_number', $orderReference)->first();

    if ($order) {
        return $order->offers()
            ->where('delegate_id', $user->id)
            ->where('status', '!=', OrderOffer::CustomerReject)
            ->exists() || $user->is($order->User) || $user->is($order->Delegate);
    }

    return false;
    //return $user->id === ($order = Order::firstOrNew(['reference_number' => $orderReference]))->delegate_id
    //    || $user->id === $order->user_id;
});

Broadcast::channel('orders.{mobile}', function ($user, $mobile) {
    return $user->mobile == $mobile;
});
Broadcast::channel('socket-status', function ($user) {
    return $user->isDelegate();
});


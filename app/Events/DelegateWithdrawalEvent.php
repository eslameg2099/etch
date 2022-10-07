<?php

namespace App\Events;

use App\Http\Resources\Orders\OrderResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use App\Models\Users\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DelegateWithdrawalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Orders\Order
     */
    public $order;

    /**
     * @var \App\Models\Users\User
     */
    public $delegate;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Orders\Order $order
     * @param \App\Models\Users\User $delegate
     */
    public function __construct(Order $order, User $delegate)
    {
        $this->order = $order;
        $this->delegate = $delegate;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("order-{$this->order->reference_number}");
    }

    public function broadcastAs()
    {
        return "withdrawal-from-order";
    }

    public function broadcastWith()
    {
        return [
            'order' => new OrderResource($this->order->refresh()),
            'message' => __('نعتذر انسحب المندوب من هذا الطلب برجاء اعادة الطلب مره اخري'),
        ];
    }
}

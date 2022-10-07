<?php

namespace App\Events;

use App\Http\Resources\Delegates\OfferResource;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Orders\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerPayOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Orders\Order
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Orders\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('order-'.$this->order->reference_number);
    }

    public function broadcastAs()
    {
        return "customer-pay-order";
    }

    public function broadcastWith()
    {
        return [
            'order' => new OrderResource($this->order),
        ];
    }
}

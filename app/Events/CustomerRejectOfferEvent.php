<?php

namespace App\Events;

use App\Http\Resources\Delegates\OfferResource;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerRejectOfferEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $offer;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order, OrderOffer $offer)
    {
        $this->order    =   $order;
        $this->offer =   $offer;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("user.{$this->offer->delegate_id}");
    }

    public function broadcastAs()
    {
        return "rejected-from-order";
    }

    public function broadcastWith() {
        return [
            'order'         =>  new OrderResource($this->order),
            'offer'         =>  new OfferResource($this->offer),
        ];
    }
}

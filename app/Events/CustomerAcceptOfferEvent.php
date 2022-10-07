<?php

namespace App\Events;

use App\Http\Resources\Delegates\OfferResource;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Orders\OrderOffer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerAcceptOfferEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $offer;

    /**
     *
     * Create a new event instance.
     *
     * @param \App\Models\Orders\OrderOffer $offer
     */
    public function __construct(OrderOffer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('order-'.$this->offer->order->reference_number);
    }

    public function broadcastAs()
    {
        return "customer-accept-offer";
    }

    public function broadcastWith()
    {
        return [
            'order' => new OrderResource($this->offer->order),
            'offer' => new OfferResource($this->offer),
        ];
    }
}

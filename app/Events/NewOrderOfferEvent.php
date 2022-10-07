<?php

namespace App\Events;

use App\Http\Resources\Delegates\OfferResource;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Orders\OrderOffer;
use App\Models\Users\Admin;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderOfferEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Orders\OrderOffer
     */
    public $offer;

    /**
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
        // to send to specific users
        $channels = [];
        //foreach (Admin::all() as $admin) {
        //    $channels[] = new PrivateChannel('user-'.$admin->id);
        //}
        return [
            new PrivateChannel('order-'.$this->offer->order->reference_number),
            new PresenceChannel('user-'.$this->offer->order->user_id),
        ];
    }

    public function broadcastAs()
    {
        return "new-order-offer";
    }

    public function broadcastWith()
    {
        return [
            'order' => new OrderResource($this->offer->order),
            'offer' => new OfferResource($this->offer),
        ];
    }
}

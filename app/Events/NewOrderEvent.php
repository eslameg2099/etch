<?php

namespace App\Events;

use App\Factories\DeliveryOrderFactory;
use App\Factories\PurchaseOrderFactory;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Orders\Order;
use App\Models\Users\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $delegate;
    public $distance;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order, User $delegate, $distance)
    {
        $this->order    =   $order;
        $this->delegate =   $delegate;
        $this->distance =   $distance;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("user.{$this->delegate->id}");
    }

    public function broadcastAs()
    {
        return "new-order";
    }

    public function broadcastWith() {
        return [
            'order'         =>  new OrderResource($this->order),
            'delegate'      =>  new UserResource($this->delegate),
            'distance'      =>   number_format($this->distance,2).' Km' ,
        ];
    }
}

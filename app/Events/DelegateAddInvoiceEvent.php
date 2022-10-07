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

class DelegateAddInvoiceEvent implements ShouldBroadcast
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

    public function broadcastOn()
    {
        return new PrivateChannel("order-{$this->order->reference_number}");
    }

    public function broadcastAs()
    {
        return "invoice-created";
    }

    public function broadcastWith()
    {
        return [
            'order' => new OrderResource($this->order),
            'message' => __('لقد تم انشاء الفاتورة'),
        ];
    }
}

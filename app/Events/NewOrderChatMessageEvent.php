<?php

namespace App\Events;

use App\Http\Resources\Chats\MessageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Orders\Order
     */
    public $order;

    /**
     * @var \App\Models\Chat\OrderChatDetail
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $message)
    {
        $this->order = $order;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel("order-{$this->order->reference_number}");
    }

    public function broadcastAs()
    {
        return "new-order-message";
    }

    public function broadcastWith()
    {
        return [
            'message' => new MessageResource($this->message),
        ];
    }
}

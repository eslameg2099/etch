<?php

namespace App\Events;

use App\Http\Resources\AdminNotificationResource;
use App\Http\Resources\Orders\OrderResource;
use App\Models\AdminNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InteriorNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminNotification $adminNotification)
    {
        $this->notification = $adminNotification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('interior-notification');
    }
    //public function broadcastWhen()
    //{
    //    return $this->notification->type == 3;
    //}

    public function broadcastWith()
    {
        return [
            'order' => new AdminNotificationResource($this->notfication),
            'message' => __('لديك إشعار من الإدارة'),
        ];
    }
}

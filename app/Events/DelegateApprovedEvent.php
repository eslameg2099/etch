<?php

namespace App\Events;

use App\Http\Resources\UserResource;
use App\Models\Users\Delegate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DelegateApprovedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Users\Delegate
     */
    public $delegate;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Users\Delegate $delegate
     */
    public function __construct(Delegate $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("user.{$this->delegate->user->id}");
    }

    public function broadcastAs()
    {
        return "delegate-approved";
    }

    public function broadcastWith()
    {
        return [
            'user' => new UserResource($this->delegate->user),
        ];
    }
}

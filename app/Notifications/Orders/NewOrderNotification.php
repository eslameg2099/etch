<?php

namespace App\Notifications\Orders;

use App\Broadcasting\PusherChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message  =   $message;
    }

    public function via($notifiable)
    {
        return [PusherChannel::class];
    }

    public function pusherInterests($notifiable) {
        return [(string) $notifiable->id];
    }

    public function toPusher($notifiable)
    {
        return [
            'title'     =>  'طلب جديد',
            'body'      =>  $this->message,
        ];
    }

    public function toArray($notifiable) {
        return [
            'title'     =>  'طلب جديد',
            'body'      =>  $this->message,
        ];
    }
}

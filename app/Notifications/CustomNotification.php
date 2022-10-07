<?php

namespace App\Notifications;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Models\Imageable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CustomNotification extends Notification implements HasMedia , ShouldQueue
{
    use Queueable;
    use InteractsWithMedia;
    use HasUploader;

    /**
     * @var array
     */
    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useFallbackUrl(asset('assets/images/ic_splash_logo.png'))
            ->singleFile();
        $this->addMediaCollection();
    }
    public function images()
    {
        return $this->morphMany(Imageable::class, 'Imageable');
    }
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : asset('assets/images/ic_splash_logo.png');
    }

    protected $data = [];

    /**
     * Create a new notification instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->data['via'] ?? [];
    }

    /**
     * The pusher instance for the notifiable.
     *
     * @param $notifiable
     * @return string[]
     */
    public function pusherInterests($notifiable)
    {
        return [(string)$notifiable->id];
    }

    /**
     * Get the pusher representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toPusher($notifiable)
    {
        $notifiable->addAllMediaFromTokens();
        $data = $this->data['fcm'] ?? [];

        return array_merge($data, [
            'notification_id' => $this->id,
            'media' => $notifiable->getFirstMediaUrl() ?? null
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $notifiable->addAllMediaFromTokens();
        $data = $this->data['database'] ?? [];

        return array_merge($data, [
            'notification_id' => $this->id,
            'media' => $notifiable->getFirstMediaUrl() ?? null
        ]);
    }
}

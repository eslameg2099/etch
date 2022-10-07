<?php

namespace App\Models\Chat;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Models\Imageable;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrderChatDetail extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasUploader;

    protected $table = 'orders_chats_details';

    protected $guarded = ['id'];

    protected $casts = ['read_at' => 'datetime'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * @deprecated
     */
    public function imagable()
    {
        return $this->morphMany(Imageable::class, 'Imageable');
    }
}

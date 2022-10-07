<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AdminNotification extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasUploader;

    const TYPE_USER = 1;
    const TYPE_DELEGATE = 2;
    const TYPE_ALL = 3;

    protected $fillable = [
      'label',
      'body',
      'user_type',
      'active'
    ];
    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }
    public function images()
    {
        return $this->morphMany(Imageable::class, 'Imageable');
    }
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : asset('assets/images/ic_splash_logo.png');
    }
    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->singleFile();
    }
}

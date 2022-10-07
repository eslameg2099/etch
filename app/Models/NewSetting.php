<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class NewSetting extends \Laraeast\LaravelSettings\Models\Setting implements HasMedia
{
    use InteractsWithMedia;
    use HasUploader;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'new_settings';
}

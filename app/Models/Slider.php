<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasUploader;

    const SLIDER_TYPE = 1;
    const OFFER_TYPE = 2;

    protected $table = 'sliders';

    protected $guarded = ['id'];
}

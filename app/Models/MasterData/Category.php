<?php

namespace App\Models\MasterData;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Http\Filters\CategoryFilter;
use App\Http\Filters\Filterable;
use App\Models\Shop;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements TranslatableContract, HasMedia
{
    use HasFactory;
    use Translatable;
    use HasUploader;
    use InteractsWithMedia;
    use SoftDeletes;
    use Filterable;

    public $translatedAttributes = ['name'];

    protected $fillable = [
        'is_active',
    ];

    protected $filter = CategoryFilter::class;

    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

    public function shops()
    {
        return $this->hasMany(Shop::class, 'category_id', 'id')->whereNull('by_user');
    }

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->useFallbackUrl(asset('assets/images/ic_splash_logo.png'))
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(70)
                    ->format('png');

                $this->addMediaConversion('small')
                    ->width(120)
                    ->format('png');

                $this->addMediaConversion('medium')
                    ->width(160)
                    ->format('png');

                $this->addMediaConversion('large')
                    ->width(320)
                    ->format('png');
            });
    }
}

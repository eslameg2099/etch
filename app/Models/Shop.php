<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Http\Filters\Filterable;
use App\Http\Filters\ShopFilter;
use App\Models\Concerns\Ratable;
use App\Models\MasterData\Category;
use App\Models\MasterData\City;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malhal\Geographical\Geographical;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Shop extends Model implements HasMedia, TranslatableContract
{
    use HasFactory;
    use SoftDeletes;
    use Ratable;
    use InteractsWithMedia;
    use HasUploader;
    use Favoriteable;
    use Filterable;
    use Translatable;
    use Geographical;
    const LATITUDE  = 'lat';
    const LONGITUDE = 'lng';

    protected static $kilometers = true;
    public $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'name',
        'category_id',
        'city_id',
        'open_at',
        'closed_at',
        'is_active',
        'except_days',
        'lat',
        'lng',
        'address',
    ];

    protected $appends = ['image_url'];

    protected $filter = ShopFilter::class;

    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }
    public function name($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('name', "%$value%");
        }
        return  $this->builder;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withTrashed();
    }


    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id')->withTrashed();
    }
    public function branches()
    {
        return $this->hasMany(Branch::class)->withTrashed();
    }


    public function images()
    {
        return $this->morphMany(Imageable::class, 'Imageable');
    }
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : asset('assets/images/ic_splash_logo.png');
    }

    public function getImageAttribute()
    {
        return asset('assets/images/ic_splash_logo.png');
        return is_null($this->image) ? asset('assets/images/ic_splash_logo.png') : asset('storage/'.$this->image);
    }

    public function scopeClosest($query)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        if (request()->has('lat') && request()->has('lng')) {
            return $query->distance(request('lat'), request('lng'))->oldest('distance');
            //return $query->selectRaw('* ,(ST_Distance_Sphere(point(lat, lng), point(?, ?))) / 1000 as distance',
            //    [request('lng'), request('lat')])
            //    ->oldest('distance');
        }

        return $query->limit(15);
    }

    public function scopeWithDistance($query)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        if (request()->has('lat') && request()->has('lng')) {
           //if($query->has('branches')) return $query->branches()->distance(request('lat'), request('lng'))->oldest('distance');
            return $query->distance(request('lat'), request('lng'))->oldest('distance');
        }

        return $query;
    }

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
        $this->addMediaCollection('menu');
    }
}

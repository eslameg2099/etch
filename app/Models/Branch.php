<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Http\Filters\BranchFilter;
use App\Http\Filters\Filterable;
use App\Models\MasterData\City;
use App\Models\Users\Address;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malhal\Geographical\Geographical;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Branch extends Model implements HasMedia, TranslatableContract
{
    use HasFactory;
    use Filterable;
    use Translatable;
    use Geographical;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasUploader;

    const LATITUDE  = 'lat';
    const LONGITUDE = 'lng';

    protected static $kilometers = true;
    public $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'shop_id',
        'name',
        'city_id',
        'lat',
        'lng',
        'address',
        'category_id'
    ];

    protected $appends = ['image_url'];

    protected $filter = BranchFilter::class;

    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id')->withTrashed();
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class)->withTrashed();
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
        }
        return $query->limit(15);
    }
    public function scopeWithDistance($query)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        if (request()->has('lat') && request()->has('lng')) {
            //return $query->distance(request('lat'), request('lng'))->orderBy('distance','desc')->latest();
            return $query->distance(request('lat'), request('lng'))->oldest('distance');
        }elseif (request()->has('delivery_address_id'))
        {
            $address = Address::findOrFail(request('delivery_address_id'));
            return $query->distance($address->lat, $address->lng)->oldest('distance');
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

<?php

namespace App\Models\MasterData;

use App\Http\Filters\CityFilter;
use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Database\Factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;
    use Filterable;

    public $translatedAttributes = ['name'];

    protected $fillable = ['country_id', 'delivery_cost', 'purchase_delivery_cost'];

    protected $filter = CityFilter::class;

    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    protected static function newFactory()
    {
        return CityFactory::new();
    }
}

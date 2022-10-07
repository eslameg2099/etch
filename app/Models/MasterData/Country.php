<?php

namespace App\Models\MasterData;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Database\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name'];

    protected $fillable = ['name'];

    protected static function newFactory()
    {
        return CountryFactory::new();
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}

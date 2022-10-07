<?php

namespace App\Models\Users;

use App\Models\MasterData\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    =   'user_addresses';
    protected $guarded  =   ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}

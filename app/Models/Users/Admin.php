<?php

namespace App\Models\Users;

use App\Models\MasterData\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admins';

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'mobile',
        'city_id',
        'password',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'mobile_verified_at' => 'datetime',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset('dashboard_assets/images/logo/user.png');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withTrashed();
    }
}

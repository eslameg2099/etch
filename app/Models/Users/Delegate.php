<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Delegate extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    protected $guard = 'delegates';

    protected $table = 'delegates';

    protected $guarded = ['id', 'can_receive_cash_orders'];

    protected $hidden = ['password'];

    protected $casts = [
        'mobile_verified_at' => 'datetime',
    ];

    protected $appends = [
        'national_id_front_image_url',
        'national_id_back_image_url',
        'vehicle_number_image_url',
    ];

    public function getNationalIdFrontImageUrlAttribute()
    {
        return asset("storage/{$this->national_id_front_image}");
    }

    public function getNationalIdBackImageUrlAttribute()
    {
        return asset("storage/{$this->national_id_back_image}");
    }

    public function getVehicleNumberImageUrlAttribute()
    {
        return asset("storage/{$this->vehicle_number_image}");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

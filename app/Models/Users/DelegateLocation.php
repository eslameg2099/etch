<?php

namespace App\Models\Users;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DelegateLocation extends Model
{
    use HasFactory;
    protected $table    =   'delegate_locations';
    protected $guarded  =   ['id'];
    protected $appends  =   ['long'];

    public function delegate() {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function getLongAttribute() {
        return $this->lng;
    }

    public static function scopeGetClosest($query, $lat, $lng) {
        return $query
            ->selectRaw('(ST_Distance_Sphere(point(lat, lng), point(?, ?))) / 1000 as distance', [$lng, $lat])
            ->whereRaw(DB::raw(' id in (select MAX(id) from delegate_locations group by delegate_id)'));

    }

}

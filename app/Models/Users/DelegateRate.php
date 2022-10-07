<?php

namespace App\Models\Users;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelegateRate extends Model
{
    use HasFactory;

    protected $table    =   'delegates_rates';
    protected $guarded  =   ['id'];

    public function rateable() {
        return $this->morphTo();
    }
    public function order() {
        return $this->belongsTo(Order::class, 'order_id' , 'id');
    }
}

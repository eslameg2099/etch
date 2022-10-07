<?php

namespace App\Models;

use App\Http\Filters\CouponFilter;
use App\Http\Filters\Filterable;
use App\Models\Orders\OrderPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'percentage_value',
        'usage_count',
        'only_once',
        'only_new'
    ];

    protected $filter = CouponFilter::class;

    /**
     * @returns Order collection
     */
    public function orderPayments()
    {
        return $this->hasMany(OrderPayment::class,'coupon_id');
    }
}

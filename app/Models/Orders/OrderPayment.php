<?php

namespace App\Models\Orders;

use App\Models\Coupon;
use App\Models\PaymentTransaction;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;

class OrderPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_payment';

    protected $guarded = ['id'];

    ### Status ###
    const Pending = 1;

    const Accepted = 2;

    const TimeOut = 3;

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(PaymentTransaction::class, 'payment_transaction_id', 'id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(OrderPaymentDetails::class, 'order_payment_id', 'id');
    }

    public function staticDetails()
    {
        return $this->hasMany(OrderPaymentDetails::class, 'order_payment_id', 'id')
            ->whereIn('item_type', [OrderPaymentDetails::DeliveryCost, OrderPaymentDetails::TaxCost]);
    }

    public function itemsDetails()
    {
        return $this->hasMany(OrderPaymentDetails::class, 'order_payment_id', 'id')
            ->where('item_type', OrderPaymentDetails::PurchasableItem);
    }

    public function getDiscount()
    {
        $discount = 0;

        if (! $this->coupon) {
            return $discount;
        }

        return ($this->order->getDeliveryCost() * $this->coupon->percentage_value) / 100;
    }

    public function getTotal()
    {
        return $this->amount - $this->getDiscount();
    }
    public function getDelegateCommission()
    {
        $discounted_price = ($this->getTotal() * Settings::get("app_profits_percent") / 100);

        return $this->getTotal() - $discounted_price;
    }
}

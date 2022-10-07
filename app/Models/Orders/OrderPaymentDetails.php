<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPaymentDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_payment_details';
    protected $guarded  =   ['id'];

    ### item type ###
    const DeliveryCost      =   1;
    const TaxCost           =   2;
    const PurchasableItem   =   3;

    public function orderPayment() {
        return $this->belongsTo(OrderPayment::class, 'order_id', 'id');
    }

}

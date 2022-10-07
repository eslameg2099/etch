<?php

namespace App\Http\Resources\Orders;

use App\Models\Order;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        =>  $this->id,
            'sub_total'     =>  $this->amount,
            'discount'     =>  $this->getDiscount(),
            'total'     =>  $this->getTotal(),
            'delegate_commission'     =>  price($this->getDelegateCommission()),
            'status'    =>  $this->status,
            'readable_status'   =>  $this->readable_status,
            'coupon'            =>  $this->coupon ? $this->coupon->code : null,
            'items'         =>  $this->when($this->details , PaymentDetailsResource::collection($this->itemsDetails)),
            'details'       =>  $this->when($this->details , PaymentDetailsResource::collection($this->staticDetails)),
            'created_at'    =>  $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}

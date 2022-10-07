<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\BranchResource;
use App\Http\Resources\Delegates\OfferResource;
use App\Http\Resources\ShopResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\Users\AddressResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use Illuminate\Http\Resources\Json\JsonResource;

use Laraeast\LaravelSettings\Facades\Settings;

use function PHPUnit\Framework\returnValue;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $delegate = $this->delegate;

        return [
            'id' => $this->id,
            'delegate_commission' => $this->when($this->delivery_cost,function (){
                return price($this->delivery_cost - ($this->delivery_cost * Settings::get("app_profits_percent") / 100));
            }),
            'user' => new UserResource($this->user),
            'delegate_offer' => $this->when(! is_null($delegate), new OfferResource($this->acceptedOffer->first())),
            //ma7al
            'receiving_address' => $this->when($this->receiving_address_id, function () {
                return new AddressResource($this->receivingAddress);
            }),
            'delivery_address' => $this->when($this->delivery_address_id, function () {
                return new AddressResource($this->DeliveryAddress);
            }),
            'type' => (int)$this->type,
            'readable_type' => $this->readable_type,
            'is_schedule' => (int)$this->is_schedule,
            'schedule_date' => $this->schedule_date,
            'shop' => $this->when($this->shop_id, function () {
                return new ShopResource($this->shop);
            }),
            'branch' => $this->when($this->branch_id, function () {
                return new BranchResource($this->branch);
            }),
            'status' => (int)$this->getStatus(),
            'readable_status' => $this->readable_status,
            'status_color' => $this->getStatusColor(),
            'payment_type' => $this->payment_type,
            'readable_payment_type' => $this->getReadablePaymentType(),
            'reference_number' => $this->reference_number,
            'order_description' => $this->order_description,
            'start_at' => $this->start_at,
            'closed_at' => $this->closed_at,
            'offer' => $this->when(is_null($delegate) && $this->whenLoaded('offers'), function () {
                return OfferResource::collection($this->offers);
            }),
            'payment' => $this->when($this->payment, new PaymentResource($this->payment)),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'can_cancel' => ! in_array($this->status, [
                Order::PaymentDone,
                Order::UnderReview,
                Order::UnderDelivery,
                Order::Delivered,
                Order::CanceledSchedule,
                Order::CanceledByUser,
                Order::CanceledBySystem,
                Order::CanceledAutomatic,
                Order::CanceledByDelegate,
            ]),
        ];
    }

    public function getStatusColor()
    {
        switch ($this->status) {
            case Order::Delivered:
                $color = '#0A774A';
                break;
            case Order::CanceledByDelegate:
            case Order::CanceledByUser:
            case Order::RefusedByAdmin:
            case Order::CanceledBySystem:
            case Order::CanceledAutomatic:
                $color = '#E12948';
                break;
            default:
                $color = '#FF9100';
                break;
        }

        return $color;
    }
    public function getReadablePaymentType()
    {
        switch ($this->payment_type) {
            case Order::PAYMENT_ON_DELIVERY:
                return __('دفع عند الاستلام');
            case Order::ONLINE_PAYMENT:
                return  __('دفع مباشر');
            case Order::PAYMENT_FROM_WALLET:
                return  __('دفع من المحفظة');
        }
    }
    private function getStatus()
    {
        /** @var User $user */
        if ($user = auth('sanctum')->user()) {
            if ($user->isDelegate()
                && $this->offers()->where('delegate_id', $user->id)->where('status', OrderOffer::CustomerReject)->exists()) {
                return Order::CanceledByUser;
            }
        }

        return $this->status;
    }
}

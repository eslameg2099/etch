<?php

namespace App\Http\Resources;

use App\Models\Orders\Order;
use App\Models\Users\Admin;
use Illuminate\Http\Resources\Json\JsonResource;

use Laraeast\LaravelSettings\Facades\Settings;

use function PHPUnit\Framework\isInstanceOf;

/** @mixin \App\Models\Users\Delegate */
class DelegateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'national_id' => $this->when($this->sameUserOrAdmin(), function () {
                return $this->national_id;
            }),
            'vehicle_type' => $this->when($this->sameUserOrAdmin(), function () {
                return $this->vehicle_type;
            }),
            'vehicle_model' => $this->when($this->sameUserOrAdmin(), function () {
                return $this->vehicle_model;
            }),
            'vehicle_number' => $this->vehicle_number,
            'is_approved' => (int)$this->is_approved,
            'is_available' => (bool)$this->is_available,
            'has_working_order' => $this->user->delegateOrders()->whereIn('status', [
                Order::WaitingForAddPayment,
                Order::WaitingForPayment,
                Order::PaymentDone,
                Order::UnderReview,
                Order::UnderDelivery,
            ])->exists(),
            'national_id_front_image' => $this->user->getFirstMediaUrl('national_id_front_image'),
            'national_id_back_image' => $this->user->getFirstMediaUrl('national_id_back_image'),
            'vehicle_number_image' => $this->user->getFirstMediaUrl('vehicle_number_image'),
            'can_receive_cash_orders' => ! ! $this->can_receive_cash_orders,
            'hold_balance' => $this->when(! ! $this->can_receive_cash_orders, function () {
                return Settings::get('delegate_hold_amount');
            }),
        ];
    }

    private function sameUserOrAdmin()
    {
        return
            (auth()->check() && $this->user_id == auth()->id()) ||
            (auth()->check() && auth()->user() instanceof Admin);
    }
}

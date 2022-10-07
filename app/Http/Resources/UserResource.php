<?php

namespace App\Http\Resources;

use App\Http\Resources\MasterData\CityResource;
use App\Models\Orders\Order;
use App\Models\Users\User;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $completedOrders = $this->isDelegate()
            ? $this->delegateOrders()->where('status', Order::Delivered)->count() : 0;

        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'type' => (int)$this->type,
            'readable_type' => $this->readable_type,
            'balance' => $this->getBalance(),
            'city' => new CityResource($this->city),
            'is_active' => (int)$this->is_active,
            'delegate' => $this->when($this->isDelegate(), function () {
                return new DelegateResource($this->delegate);
            }),
            //'rate' => $this->when($this->isDelegate(), function () {
            //    return (string)  $this->delegateOrders()->has('entityRate')->avg('rate');
            //}),
            'rate' => $this->when($this->isDelegate(), function () {
                return (string)  $this->rate;
            }),
            'rate_count' => $ratesCount = $this->when($this->isDelegate(), function () {
                return (int) $this->delegateOrders()->has('entityRate')->count();
            }),
            'points' => $ratesCount,
            'points_logo' => $this->when($this->isDelegate(), function () {
                return $this->getDelegateMembership() ? $this->getDelegateMembership()->getFirstMediaUrl() : null;
            }),
            'mobile_verified' => (int)! is_null($this->mobile_verified_at),
            'image' => $this->getFirstMediaUrl(),
            'address_count' => $this->addresses->count(),
            'cancellation_attempts' => (int) $this->cancellation_attempts,
            'completed_orders' => $this->when($this->isDelegate(), $completedOrders),
            'rates' => DelegateRateResource::collection($this->delegateOrders()->has('entityRate')->with('entityRate')->limit(3)->latest()->get()),
            'credit' => $this->credit
        ];
    }
}

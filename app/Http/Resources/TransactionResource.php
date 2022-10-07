<?php

namespace App\Http\Resources;

use App\Http\Resources\MasterData\CityResource;
use App\Models\Orders\Order;
use App\Models\Users\User;
use App\Support\Payment\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Support\Payment\Models\Transaction */
class TransactionResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->getTitle(),
            'amount' => abs($this->amount),
            'type' => $this->getType(),
            'readable_type' => $this->getReadableType(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }

    public function getTitle()
    {
        if ($this->actor && $this->actor->isNot($this->user) && ! $this->order_id && $this->amount > 0) {
            return trans('transactions.admin-recharge');
        }

        if ($this->actor && $this->actor->isNot($this->user) && ! $this->order_id && $this->amount < 0) {
            return trans('transactions.admin-withdrawal');
        }

        if ($this->actor && $this->actor->is($this->user) && ! $this->order_id && $this->amount > 0) {
            return trans('transactions.recharge');
        }

        if ($this->actor && $this->actor->is($this->user) && ! $this->order_id && $this->amount < 0) {
            return trans('transactions.withdrawal');
        }

        if ($this->order_id) {
            return trans('transactions.order.'.$this->type, ['order' => $this->order_id]);
        }
    }

    public function getReadableType()
    {
        if ($this->amount >= 0) {
            return trans('transactions.types.deposit');
        }

        return trans('transactions.types.withdrawal');
    }

    public function getType()
    {
        if ($this->amount >= 0) {
            return 'deposit';
        }

        return 'withdrawal';
    }
}

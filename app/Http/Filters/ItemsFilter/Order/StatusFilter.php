<?php

namespace App\Http\Filters\ItemsFilter\Order;

use App\Http\Filters\Base\AbstractBasicFilter;
use App\Models\Orders\Order;

class StatusFilter extends AbstractBasicFilter
{
    public function filter($value)
    {
        $new = [
            Order::WaitingForOffers,
            Order::WaitingForAcceptOffer,
            Order::ChangeDelegate,
        ];

        if ($value == 1) {
            return $this->builder->where(function ($query) use ($new) {
                if (auth()->check() && auth()->user()->isCustomer()) {
                    $query->whereIn('status', collect($new)->add(Order::Schedule))
                    ->where('user_id', auth()->id());
                } else {
                    $query->whereIn('status', $new);
                }
            });
        }

        if ($value == 2) {
            return $this->builder
                ->whereIn('status', [
                    Order::WaitingForAddPayment,
                    Order::WaitingForPayment,
                    Order::PaymentDone,
                    Order::UnderReview,
                    Order::UnderDelivery,
                ])
                ->when(auth()->check() && auth()->user()->isDelegate(), function ($query) {
                    $query->where('delegate_id', auth()->id());
                });
        }

        if ($value == 3) {
            return $this->builder
                ->whereIn('status', [
                    Order::Delivered,
                    Order::CanceledByDelegate,
                    Order::CanceledByUser,
                    Order::CanceledBySystem,
                    Order::CanceledAutomatic,
                    Order::RefusedByAdmin,
                    Order::CanceledSchedule,
                    Order::PaymentTimeOut,
                ])
                ->when(auth()->check() && auth()->user()->isDelegate(), function ($query) {
                    $query->where('delegate_id', auth()->id());
                });
        }

        return $this->builder;
    }
}

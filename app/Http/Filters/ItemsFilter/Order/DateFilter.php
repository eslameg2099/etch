<?php


namespace App\Http\Filters\ItemsFilter\Order;


use App\Http\Filters\Base\AbstractBasicFilter;
use Carbon\Carbon;

class DateFilter extends AbstractBasicFilter
{
    public function filter($value)
    {
        if($value == 1) {
            return $this->builder->whereDate('created_at', '=',Carbon::today());
        } else if ($value == 2) {
            return $this->builder->whereDate('created_at', '<=',Carbon::yesterday());
        }
        return $this->builder;

    }
}

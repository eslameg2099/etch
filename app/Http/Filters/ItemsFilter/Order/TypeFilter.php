<?php


namespace App\Http\Filters\ItemsFilter\Order;


use App\Http\Filters\Base\AbstractBasicFilter;

class TypeFilter extends AbstractBasicFilter
{
    public function filter($value)
    {
        return $this->builder->where('type', $value);
    }
}

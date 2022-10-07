<?php


namespace App\Http\Filters\ModelFilter;


use App\Http\Filters\ItemsFilter\Order\DateFilter;
use App\Http\Filters\ItemsFilter\Order\StatusFilter;
use App\Http\Filters\ItemsFilter\Order\TypeFilter;
use App\Http\Filters\Base\AbstractFilter;

class OrderModelFilter extends AbstractFilter
{
    protected $filters  =   [
        'type'      =>  TypeFilter::class,
        'date'      =>  DateFilter::class,
        'status'    =>  StatusFilter::class
    ];
}

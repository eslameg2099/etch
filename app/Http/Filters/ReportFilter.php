<?php

namespace App\Http\Filters;

class ReportFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'user_id',
        'delegate_id',
        'order_id',
        'status',
    ];

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function userId($value)
    {
        if ($value) {
            return $this->builder->where('user_id', $value);
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function delegateId($value)
    {
        if ($value) {
            return $this->builder->where('delegate_id', $value);
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function orderId($value)
    {
        if ($value) {
            return $this->builder->where('order_id', $value);
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status($value)
    {
        if ($value) {
            return $this->builder->where('status', $value);
        }

        return $this->builder;
    }
}

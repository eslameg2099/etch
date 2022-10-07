<?php

namespace App\Http\Filters;

class CouponFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'code',
        'percentage_value',
        'usage_count',
    ];

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function code($value)
    {
        if ($value) {
            return $this->builder->where('code', 'like', "%$value%");
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function percentageValue($value)
    {
        if ($value) {
            return $this->builder->where('percentage_value', $value);
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function usageCount($value)
    {
        if ($value) {
            return $this->builder->where('usage_count', $value);
        }

        return $this->builder;
    }
}

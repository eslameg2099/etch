<?php

namespace App\Http\Filters;

class MembershipFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'rates_count',
    ];

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
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
    protected function ratesCount($value)
    {
        if ($value) {
            return $this->builder->where('rates_count', $value);
        }

        return $this->builder;
    }
}

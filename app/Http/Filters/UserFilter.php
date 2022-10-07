<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'mobile',
        'national_id',
        'type',
        'is_active',
        'is_approved',
        'cancellation_attempts',
    ];

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder->where('name', 'like', "%$value%");
        }

        return $this->builder;
    }
    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function nationalId($value)
    {
        if ($value) {
            return $this->builder->whereHas('delegate' , function ($query) use($value) {
                $query->where('delegates.national_id', 'like', "%$value%");
            });
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function mobile($value)
    {
        if ($value) {
            return $this->builder->where('mobile', 'like', "%$value%");
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($value)
    {
        if ($value) {
            return $this->builder->where('type', $value);
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function isActive($value)
    {
        if (! is_null($value)) {
            $this->builder->where('is_active', $value);
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function isApproved($value)
    {
        if (! is_null($value)) {
            $this->builder->whereHas('delegate', function (Builder $builder) use ($value) {
                $builder->where('is_approved', $value);
            });
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function cancellationAttempts($value)
    {
        return $this->builder->where('cancellation_attempts', 0);
    }
}

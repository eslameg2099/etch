<?php

namespace App\Http\Filters;

class ShopFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'category_id',
        'city_id',
        'sort',
        'is_active',
    ];

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function categoryId($value)
    {
        if ($value) {
            return $this->builder->where('category_id', $value);
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function cityId($value)
    {
        if ($value) {
            return $this->builder->where('city_id', $value);
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function sort($value)
    {
        switch ($value) {
            case 'nearest';
                return $this->builder->oldest('distance');
            case 'rate';
                return $this->builder->latest('rate');
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
}

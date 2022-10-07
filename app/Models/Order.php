<?php

namespace App\Models;

use App\Http\Filters\BaseFilters;
use App\Http\Filters\OrderFilter;
use App\Models\Orders\Order as OrderModel;
use Illuminate\Support\Facades\App;

class Order extends OrderModel
{
    protected $filter = OrderFilter::class;

    /**
     * Apply all relevant thread filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Http\Filters\BaseFilters|null $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterableFilter($query, BaseFilters $filters = null)
    {
        if (! $filters) {
            $filters = App::make($this->filter);
        }

        return $filters->apply($query);
    }

    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }
}

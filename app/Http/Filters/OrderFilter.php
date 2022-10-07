<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'status',
        'type',
        'created_at',
    ];

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
    protected function createdAt($value)
    {
        $from = explode(' - ', $value)[0] ?? null;
        $to = explode(' - ', $value)[1] ?? null;
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);

        if ($value) {
            return $this->builder->whereBetween(DB::raw('DATE(created_at)'), [$from, $to]);
        }

        return $this->builder;
    }
}

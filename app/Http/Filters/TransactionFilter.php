<?php

namespace App\Http\Filters;

use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @property-read \Illuminate\Database\Eloquent\Builder|\App\Support\Payment\Models\Transaction $builder
 */
class TransactionFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'type',
        'user_type',
        'status',
        'created_at',
    ];

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($value)
    {
        switch ($value) {
            case 'withdrawal':
                $this->builder->where('amount', '<', 0);
                break;
            case 'deposit':
                $this->builder->where('amount', '>=', 0);
                break;
            default:
                if ($value) {
                    $this->builder->where('type', $value);
                }
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function userType($value)
    {
        switch ($value) {
            case 'users':
                $this->builder->whereHas('user', function (Builder $builder) {
                    $builder->where('type', User::User);
                });
                break;
            case 'delegates':
                $this->builder->whereHas('user', function (Builder $builder) {
                    $builder->where('type', User::Delegate);
                });
                break;
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status($value)
    {
        if (! $value) {
            return $this->builder;
        }

        if (Str::contains($value, '-')) {
            $value = explode('-', $value);
        }

        return $this->builder->whereIn('status', Arr::wrap($value));
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


        if ($from && $to) {
            return $this->builder->whereBetween(DB::raw('DATE(created_at)'), [$from, $to]);
        }

        return $this->builder;
    }
}

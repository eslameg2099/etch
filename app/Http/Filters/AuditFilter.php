<?php

namespace App\Http\Filters;

class AuditFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'user_id',
        'auditable_id'
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
    protected function auditableId($value)
    {
        if ($value) {
            return $this->builder->where('auditable_id', $value);
        }

        return $this->builder;
    }
}

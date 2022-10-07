<?php

namespace App\Models\Concerns;

use App\Models\Rate;

trait Ratable
{
    /**
     * Get all the entity rates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function rates()
    {
        return $this->morphMany(Rate::class, 'ratable');
    }

    /**
     * Get the first entity rates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function entityRate()
    {
        return $this->morphOne(Rate::class, 'ratable');
    }
}
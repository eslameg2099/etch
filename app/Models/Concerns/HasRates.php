<?php

namespace App\Models\Concerns;

use App\Models\Rate;
use Illuminate\Database\Eloquent\SoftDeletes;

trait HasRates
{
    /**
     * Get all the user's rates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates()
    {
        return $this->hasMany(Rate::class, 'user_id');
    }

    /**
     * Boot the has rates trait for a model.
     *
     * @return void
     */
    public static function bootHasRates()
    {
        static::deleting(function (self $model) {
            if (in_array(SoftDeletes::class, class_uses_recursive($model))) {
                if (! $model->forceDeleting) {
                    return;
                }
                $model->rates()->cursor()->each(function (Rate $rate) {
                    return $rate->delete();
                });
            }
        });
    }
}
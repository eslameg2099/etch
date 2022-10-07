<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Rate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'rate',
        'user_id',
        'comment',
    ];

    /**
     * Get the ratable entity of the rate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function ratable()
    {
        return $this->morphTo('ratable');
    }

    /**
     * Get the user who rate the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saved(function (self $model) {
            if (Schema::hasColumn($model->ratable->getTable(), 'rate')) {
                $model->ratable->forceFill([
                    'rate' => (int)$model->ratable->rates()->average('rate'),
                ])->save();
            }
        });
    }
}

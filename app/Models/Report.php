<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\ReportFilter;
use App\Models\Users\User;
use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;
    use Filterable;

    const NEW_REPORT = 0;
    const IN_PROGRESS = 1;
    const DONE = 2;
    const CLOSED = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'delegate_id',
        'order_id',
        'message',
    ];

    protected $filter = ReportFilter::class;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delegate()
    {
        return $this->belongsTo(User::class, 'delegate_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

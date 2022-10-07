<?php

namespace App\Models\Chat;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;

class OrderChat extends Model
{
    use HasFactory;

    protected $table = 'orders_chats';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function delegate()
    {
        return $this->belongsTo(User::class, 'delegate_id', 'id')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withTrashed();
    }

    public function messages()
    {
        return $this->hasMany(OrderChatDetail::class, 'order_chat_id', 'id');
    }

    public function lastMessage()
    {
        return $this->messages()->latest()->limit;
    }

    public function scopeMyChats($query, $userId = null)
    {
        return $query
            ->whereHas('order', function (Builder $builder) {
               $builder->where('user_id', auth()->id());
               $builder->orWhere('delegate_id', auth()->id());
               $builder->whereNotIn('status', [
                   Order::Delivered,
                   Order::CanceledByDelegate,
                   Order::CanceledByUser,
                   Order::CanceledBySystem,
                   Order::CanceledAutomatic,
                   Order::CanceledSchedule,
               ]);
            });
    }
}

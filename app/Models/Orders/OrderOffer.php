<?php

namespace App\Models\Orders;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class OrderOffer extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table    =   'order_offers';
    protected $guarded  =   ['id'];
    protected $appends  =   ['readable_status', 'long'];
    protected $auditTimestamps = true;
    
    ### status ###
    const WaitingDelegateAction =   1;
    const DelegateAccept        =   2;
    const CustomerAccept        =   3;
    const CustomerReject        =   4;
    const CustomerRefuseDelegate=   5;
    const DelegateCancel        =   6;
    const DelegateWithdrawal    =   7;
    const OrderDeliveredSuccess =   8;
    const CanceledByUser        =   9;

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function delegate() {
        return $this->belongsTo(User::class, 'delegate_id', 'id')->withTrashed();
    }

    public function getReadableStatusAttribute() {
        return [
            self::WaitingDelegateAction =>  'بانتظار اتخاذ اجراء',
            self::DelegateAccept        =>  'تم قبول العرض من قبل المندوب',
            self::CustomerAccept        =>  'تم قبول العرض من قبل العميل',
            self::CustomerReject        =>  'تم رفض العرض من قبل العميل',
            self::CustomerRefuseDelegate=>  'تم تغير المندوب من قبل العميل',
            self::DelegateCancel        =>  'قام المندوب بالغاء الطلب',
            self::DelegateWithdrawal    =>  'قام المندوب بالانسحاب من الطلب',
            self::OrderDeliveredSuccess =>  'قام المندوب بتسليم الطلب',
            self::CanceledByUser        =>  'تم الإلغاء من قبل العميل',
            null    =>  '',
        ][$this->status];
    }

    public function scopeNewDelegateOrders($query) {
        return $query->where('delegate_id' , auth()->id())
            ->whereIn('status' , [
                OrderOffer::CustomerAccept,
                OrderOffer::DelegateAccept,
                OrderOffer::WaitingDelegateAction
            ]);
    }

    public function scopeDelegateCanWithdrawal($query) {
        return $query->where('delegate_id', auth()->id())
            ->whereIn('status' , [
                OrderOffer::DelegateAccept,
                OrderOffer::WaitingDelegateAction,
                OrderOffer::CustomerAccept
            ]);
    }

    public function getLongAttribute() {
        return $this->lng;
    }
}

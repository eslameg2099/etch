<?php

namespace App\Support\Payment\Concerns;

use Illuminate\Support\Facades\DB;
use App\Support\Payment\Models\Transaction;

trait HasTransactions
{
    /**
     * Get all the entity's transactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Get all the grouped entity's transactions for humans.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionsForHumans()
    {
        return $this->transactions();
    }

    public function getBalance()
    {
        return $this->transactions()->parentsOnly()->whereIn('status', [
            Transaction::BALANCE_STATUS,
            Transaction::WITHDRAWAL_REQUEST_STATUS,
            Transaction::WITHDRAWAL_STATUS,
        ])->sum('amount');
    }
    public function getBalanceWithTransaction($date)
    {
        return $this->transactions()->parentsOnly()->whereIn('status', [
            Transaction::BALANCE_STATUS,
            Transaction::WITHDRAWAL_REQUEST_STATUS,
            Transaction::WITHDRAWAL_STATUS,
        ])->where('created_at','<=',$date)->sum('amount');
    }

    public function getHoldBalance()
    {
        return $this->transactions()->parentsOnly()->whereIn('status', [
            Transaction::HOLED_STATUS,
        ])->sum('amount');
    }
}
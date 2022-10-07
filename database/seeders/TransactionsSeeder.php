<?php

namespace Database\Seeders;

use App\Models\Users\User;
use App\Support\Payment\Facades\Cashier;
use App\Support\Payment\Models\Checkout;
use App\Support\Payment\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::each(function (User $user) {
            $checkout = Checkout::create([
                'user_id' => $user->id,
                'checkout_id' => '6770EF169BDFB8D50DB9803CFD643F2F.uat01-vm-tx04',
                'transaction_identifier' => Str::random(50),
                'amount' => 200,
                'payment_type' => 'visa',
                'status' => '000.100.112',
            ]);
            $status = Transaction::PENDING_STATUS;

            if ($checkout->isPending()) {
                $status = Transaction::PENDING_STATUS;
            }
            if ($checkout->isSuccessfulAndPending() || $checkout->isSuccessful()) {
                $status = Transaction::BALANCE_STATUS;
            }
            if ($checkout->isRejected() || $checkout->isRejectedByExternalBank()) {
                $status = Transaction::REJECTED_STATUS;
            }
            $checkout->transactions()->create([
                'user_id' => $user->id,
                'actor_id' => $user->id,
                'identifier' => $checkout->transaction_identifier,
                'amount' => $checkout->amount,
                'status' => $status,
                'type' => Transaction::BALANCE_RECHARGE,
                'date' => now()->subHour(),
            ]);
            $user->transactions()->create([
                'user_id' => $user->id,
                'actor_id' => $user->id,
                'identifier' => Str::random(50),
                'amount' => -100,
                'status' => Transaction::WITHDRAWAL_REQUEST_STATUS,
                'type' => Transaction::WITHDRAWAL_TYPE,
                'date' => now(),
                'account_name' => 'test',
                'bank_name' => 'test',
                'account_number' => 123,
                'iban_number' => 147,
            ]);
        });
    }
}

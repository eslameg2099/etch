<?php

namespace App\Http\Controllers\Api;

use App\Events\WalletRechargeEvent;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Support\Payment\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Payment\Facades\Cashier;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laraeast\LaravelSettings\Facades\Settings;

class WalletController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function prepareCheckout(Request $request)
    {
        $request->validate([
            'amount' => ['required'],
            'payment_type' => ['required', Rule::in(array_keys(config('services.hyperpay.payment_methods')))],
        ]);

        /** @var \App\Models\Users\User $user */
        $user = auth()->user();

        $checkout = Cashier::setUser($user)->prepareCheckout(
            $request->amount,
            $request->payment_type,
        );

        return response()->json([
            'checkout_id' => $checkout->checkout_id,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     */
    public function recharge(Request $request)
    {
        $request->validate([
            'checkout_id' => 'required|exists:checkouts,checkout_id',
        ]);

        /** @var \App\Models\Users\User $user */
        $user = auth()->user();

        Cashier::setActor($user)->setCheckout($request->checkout_id);

        $checkout = Cashier::updateStatus()->getCheckout();

        if ($checkout->transactions()->exists()) {
            throw ValidationException::withMessages([
                'checkout' => [__('The given checkout_id already used.')],
                'status' => trans('hyperpay.'. $checkout->status),
                'result-code' => $checkout->status,
                'checkout_id' => $checkout->checkout_id,
                'amount' => $checkout->amout,
            ]);
        }

        Artisan::call('wallet:sync');

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

        if (! $checkout->isSuccessful() && ! $checkout->isSuccessfulAndPending()) {
            throw ValidationException::withMessages([
                'balance' => 'Error: '. trans('hyperpay.'. $checkout->status),
                'result-code' => $checkout->status,
                'checkout_id' => $checkout->checkout_id,
                'amount' => $checkout->amout,
            ]);
        }

        //DB::beginTransaction();

        $transaction = $checkout->transactions()->create([
            'user_id' => optional(Cashier::getActor())->id,
            'actor_id' => optional(Cashier::getActor())->id,
            'identifier' => $checkout->transaction_identifier,
            'amount' => $checkout->amount,
            'status' => $status,
            'type' => Transaction::BALANCE_RECHARGE,
            'date' => now(),
        ]);

        if ($user->isDelegate() && $user->getHoldBalance() < Settings::get('delegate_hold_amount', 0)) {
            $hold = Settings::get('delegate_hold_amount', 0) - $user->getHoldBalance();

            $hold = $request->amount - $hold;
            //if ($request->amount )

        }

        //DB::commit();

        event(new WalletRechargeEvent($transaction));

        return new UserResource($user->refresh());
    }

    public function transactions()
    {
        /** @var \App\Models\Users\User $user */
        $user = auth()->user();

        $transactions = $user->transactions()->parentsOnly()->filter()->whereIn('status', [
            Transaction::BALANCE_STATUS,
            Transaction::WITHDRAWAL_REQUEST_STATUS,
        ])->latest()->simplePaginate();

        return TransactionResource::collection($transactions)->additional([
            'balance' => (float) $user->getBalance(),
        ]);
    }

    public function withdrawal(Request $request)
    {
        $request->validate([
            'account_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'iban_number' => 'required',
            'amount' => 'numeric',
        ]);

        /** @var \App\Models\Users\User $user */
        $user = auth()->user();

        if ($request->amount && $request->amount > $user->getBalance()) {
            throw ValidationException::withMessages([
                'amount' => [trans('transactions.errors.withdrawal.not-enough')],
            ]);
        }

        Cashier::setActor($user)->setUser($user);

        if ($request->remember) {
            $user->credit()->updateOrCreate([
                'user_id' => $user->id,
            ], [
                'account_name' => $request->account_name,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'iban_number' => $request->iban_number,
            ]);
        }

        $amount = $user->getBalance() * -1;

        if ($request->amount) {
            $amount = $request->amount > 0 ? ($request->amount * -1) : $request->amount;
        }

        $transaction = $user->transactions()->create([
            'user_id' => optional(Cashier::getUser())->id,
            'actor_id' => optional(Cashier::getActor())->id,
            'identifier' => Str::random(50),
            'amount' => $amount,
            'status' => Transaction::WITHDRAWAL_REQUEST_STATUS,
            'type' => Transaction::WITHDRAWAL_TYPE,
            'date' => now(),
            'account_name' => $request->account_name,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'iban_number' => $request->iban_number,
        ]);

        event(new WalletRechargeEvent($transaction));

        return response()->json([
            'message' => trans('transactions.messages.withdrawal'),
            'user' => new UserResource($user->refresh()),
        ]);
    }
}

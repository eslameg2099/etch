<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\WalletRechargeEvent;
use App\Exports\WithdrawalTransactionsExport;
use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Support\Payment\Facades\Cashier;
use App\Support\Payment\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function system()
    {
        $balance = Transaction::whereNull('user_id')->whereStatus(Transaction::BALANCE_STATUS)->parentsOnly()->sum('amount');

        $transactions = Transaction::whereNull('user_id')->parentsOnly()
            ->filter()
            ->latest('id')
            ->simplePaginate();

        return view('dashboard.wallets.system', compact('transactions', 'balance'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delegates()
    {
        $users = User::where('type', User::Delegate)->paginate();

        return view('dashboard.wallets.delegates', compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function users()
    {
        $users = User::where('type', User::User)->paginate();

        return view('dashboard.wallets.users', compact('users'));
    }

    public function show(User $user)
    {
        $balance = $user->transactions()->whereIn('status',[Transaction::BALANCE_STATUS,Transaction::WITHDRAWAL_STATUS])->parentsOnly()->sum('amount');

        $transactions = $user->transactions()
            ->parentsOnly()
            ->filter()
            ->latest()
            ->simplePaginate();
        return view('dashboard.wallets.show', compact('transactions', 'balance', 'user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdrawal()
    {
        $query = Transaction::filter()
            ->parentsOnly()
            ->latest();

        $balance = abs((clone $query)->whereStatus(Transaction::BALANCE_STATUS)->sum('amount'));

        $transactions = (clone $query)->simplePaginate();

        return view('dashboard.wallets.withdrawal', compact('transactions', 'balance'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Support\Payment\Models\Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdrawalConfirm(Transaction $transaction)
    {
        $transaction->forceFill(['status' => Transaction::WITHDRAWAL_STATUS])->save();

        return back();
    }

    public function recharge(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ], [], trans('wallets.attributes'));

        if ($request->amount == 0) {
            return back();
        }

        $type = $request->amount >= 0 ? Transaction::BALANCE_RECHARGE : Transaction::WITHDRAWAL_TYPE;

        $transaction = $user->transactions()->create([
            'identifier' => Str::random(50),
            'amount' => $request->amount,
            'status' => Transaction::BALANCE_STATUS,
            'notes' => $request->notes,
            'type' => $type,
            'date' => now(),
        ]);

        try {
            event(new WalletRechargeEvent($transaction));
        } catch (\Exception $exception) {
        }

        if ($request->amount > 0) {
            flash(trans('wallets.messages.recharge'));
        } else {
            flash(trans('wallets.messages.discount'));
        }

        return back();
    }

    public function export()
    {
        return Excel::download(new WithdrawalTransactionsExport(), date('Y-m-d').'.xls',
            \Maatwebsite\Excel\Excel::XLS);
    }
}

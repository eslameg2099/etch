<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\DelegatesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\Users\Delegate;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DelegateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delegates = User::filter()->withCount('delegateOrders')->where('type', User::Delegate)->latest()->paginate();
        return view('dashboard.delegates.index', compact('delegates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.delegates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $request->merge(['type' => User::Delegate]);

        $delegate = User::create($request->allWithHashedPassword());

        $delegate->delegate()->updateOrCreate(['user_id' => $delegate->id], $request->input('delegate', []));

        $delegate->forceFill([
            'is_active' => !! $request->input('delegate.is_approved'),
        ])->save();


        flash()->success(trans('delegates.messages.created'));

        return redirect()->route('dashboard.delegates.show', $delegate);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Users\User $delegate
     * @return \Illuminate\Http\Response
     */
    public function show(User $delegate)
    {
        $balance = $delegate->getBalance();

        $transactions = $delegate->transactions()->parentsOnly()
            ->filter()
            ->latest('id')
            ->simplePaginate();

        return view('dashboard.delegates.show', compact('delegate', 'balance', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Users\User $delegate
     * @return \Illuminate\Http\Response
     */
    public function edit(User $delegate)
    {
        return view('dashboard.delegates.edit', compact('delegate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\UserRequest $request
     * @param \App\Models\Users\User $delegate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $delegate)
    {
        if ($delegate->type == User::User) {
            flash()->error(trans('users.messages.validate'));
            return redirect()->route('dashboard.users.show', $delegate);
        }
        $request->merge(['type' => User::Delegate]);

        $delegate->makeFillable('cancellation_attempts');

        $delegate->update($request->allWithHashedPassword());

        $delegate->delegate()->updateOrCreate(['user_id' => $delegate->id], $request->input('delegate', []));

        $delegate->forceFill([
            'is_active' => !! $request->input('delegate.is_approved'),
        ])->save();
        $delegate->delegate->forceFill([
            'can_receive_cash_orders' => !! $request->input('delegate.can_receive_cash_orders'),
        ])->save();

        $delegate->addAllMediaFromTokens();

        flash()->success(trans('delegates.messages.updated'));

        return redirect()->route('dashboard.delegates.show', $delegate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Users\User $delegate
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $delegate)
    {
        $delegate->delete();

        flash()->success(trans('delegates.messages.deleted'));

        return redirect()->route('dashboard.delegates.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $delegates = User::onlyTrashed()->filter()->where('type',User::Delegate)->whereHas('delegate')->paginate();

        return view('dashboard.delegates.index', compact('delegates'));
    }

    public function restore(User $delegate)
    {
        $delegate->restore();

        flash()->success(trans('delegates.messages.restored'));

        return redirect()->route('dashboard.delegates.index');
    }
    public function export()
    {
        return Excel::download(new DelegatesExport(), date('Y-m-d').'.xls',
            \Maatwebsite\Excel\Excel::XLS);
    }

}

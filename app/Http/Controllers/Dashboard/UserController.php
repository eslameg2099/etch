<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::filter()->where('type', User::User)->latest()->paginate();

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $request->merge(['type' => User::User]);

        $user = User::create($request->allWithHashedPassword());

        flash()->success(trans('users.messages.created'));

        return redirect()->route('dashboard.users.show', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Users\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $balance = $user->getBalance();

        $transactions = $user->transactions()->parentsOnly()
            ->filter()
            ->latest('id')
            ->simplePaginate();

        return view('dashboard.users.show', compact('user', 'balance', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Users\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\UserRequest $request
     * @param \App\Models\Users\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        if ($user->type == User::Delegate) {
            flash()->error(trans('users.messages.validate'));
            return redirect()->route('dashboard.delegates.show', $user);
        }
        $request->merge(['type' => User::User]);

        $user->makeFillable('cancellation_attempts');

        $user->update($request->allWithHashedPassword());

        flash()->success(trans('users.messages.updated'));

        return redirect()->route('dashboard.users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Users\User $user
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        flash()->success(trans('users.messages.deleted'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $users = User::onlyTrashed()->filter()->where('type',User::User)->filter()->paginate();

        return view('dashboard.users.index', compact('users'));
    }

    public function restore(User $user)
    {
        $user->restore();

        flash()->success(trans('users.messages.restored'));

        return redirect()->route('dashboard.users.index');
    }
    public function export()
    {
        return Excel::download(new UsersExport(), date('Y-m-d').'.xls',
            \Maatwebsite\Excel\Excel::XLS);
    }

}

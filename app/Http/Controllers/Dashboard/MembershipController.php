<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MembershipRequest;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberships = Membership::filter()->paginate();

        return view('dashboard.memberships.index', compact('memberships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.memberships.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\MembershipRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MembershipRequest $request)
    {
        $membership = Membership::create($request->all());

        flash()->success(trans('memberships.messages.created'));

        return redirect()->route('dashboard.memberships.show', $membership);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Membership $membership
     * @return \Illuminate\Http\Response
     */
    public function show(Membership $membership)
    {
        return view('dashboard.memberships.show', compact('membership'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Membership $membership
     * @return \Illuminate\Http\Response
     */
    public function edit(Membership $membership)
    {
        return view('dashboard.memberships.edit', compact('membership'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\MembershipRequest $request
     * @param \App\Models\Membership $membership
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MembershipRequest $request, Membership $membership)
    {
        $membership->update($request->all());

        flash()->success(trans('memberships.messages.updated'));

        return redirect()->route('dashboard.memberships.show', $membership);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Membership $membership
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Membership $membership)
    {
        $membership->delete();

        flash()->success(trans('memberships.messages.deleted'));

        return redirect()->route('dashboard.memberships.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $memberships = Membership::filter()->onlyTrashed()->paginate();

        return view('dashboard.memberships.index', compact('memberships'));
    }

    public function restore(Membership $membership)
    {
        $membership->restore();

        flash()->success(trans('memberships.messages.restored'));

        return redirect()->route('dashboard.memberships.index');
    }
}

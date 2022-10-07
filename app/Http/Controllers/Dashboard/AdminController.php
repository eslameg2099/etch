<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Models\Users\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate();

        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminRequest $request)
    {
        $admin = Admin::create($request->allWithHashedPassword());

        flash()->success(trans('admins.messages.created'));

        return redirect()->route('dashboard.admins.show', $admin);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Users\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view('dashboard.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Users\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('dashboard.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\AdminRequest $request
     * @param \App\Models\Users\Admin $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $admin->update($request->allWithHashedPassword());

        flash()->success(trans('admins.messages.updated'));

        return redirect()->route('dashboard.admins.show', $admin);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Users\Admin $admin
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        flash()->success(trans('admins.messages.deleted'));

        return redirect()->route('dashboard.admins.index');
    }
}

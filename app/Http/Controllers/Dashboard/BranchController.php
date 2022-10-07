<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Models\Shop;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.branches.create');
    }
    public function createBranchShop(Shop $shop)
    {
        return view('dashboard.branches.create_with_shop', compact('shop'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BranchRequest $request)
    {
        $branch = Branch::create($request->all());
        $shop = $branch->shop;
        flash()->success(trans('branches.messages.created'));
        return redirect()->route('dashboard.shops.show', $shop);
    }
    public function storeBranchShop(Request $request , Shop $shop)
    {
        $branch = $shop->branches()->create($request->all());
        $shop = Shop::findOrFail($branch->shop_id);
        flash()->success(trans('branches.messages.created'));
        return redirect()->route('dashboard.shops.show', $shop);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        return view('dashboard.branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $branch->update($request->all());
        $shop = $branch->shop;
        flash()->success(trans('branches.messages.updated'));

        return redirect()->route('dashboard.shops.show', $shop);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        $shop = $branch->shop;
        flash()->success(trans('branches.messages.deleted'));
        return redirect()->route('dashboard.shops.show', $shop);
    }
    public function restore($branch)
    {
        $branch = Branch::withTrashed()->findOrFail($branch);
        $branch->restore();
        $shop = Shop::findOrFail($branch->shop_id);
        flash()->success(trans('branches.messages.restored'));
        return redirect()->route('dashboard.shops.show', $shop);
    }
}

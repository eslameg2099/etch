<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ShopRequest;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shops = Shop::whereTranslationLike('name', "%$request->name%")->filter()->paginate();

        return view('dashboard.shops.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ShopRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShopRequest $request)
    {
        $shop = Shop::create($request->all());

        $shop->addAllMediaFromTokens();

        flash()->success(trans('shops.messages.created'));

        return redirect()->route('dashboard.shops.show', $shop);
    }
    /**
     * Display the specified resource.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $branches = $shop->branches;
        return view('dashboard.shops.show', compact('shop','branches'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        return view('dashboard.shops.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ShopRequest $request
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ShopRequest $request, Shop $shop)
    {
        $shop->update($request->all());

        $shop->addAllMediaFromTokens();

        flash()->success(trans('shops.messages.updated'));

        return redirect()->route('dashboard.shops.show', $shop);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Shop $shop
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();

        flash()->success(trans('shops.messages.deleted'));

        return redirect()->route('dashboard.shops.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $shops = Shop::filter()->onlyTrashed()->paginate();

        return view('dashboard.shops.index', compact('shops'));
    }

    public function restore(Shop $shop)
    {
        $shop->restore();

        flash()->success(trans('shops.messages.restored'));

        return redirect()->route('dashboard.shops.index');
    }
}

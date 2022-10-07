<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;
use App\Http\Requests\Dashboard\UserRequest;

class ShopController extends Controller
{
    public function index()
    {
        return view('shop');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ShopRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShopRequest $request)
    {
        $shop = Shop::create($request->except('is_active') + ['is_active' => false]);

        $shop->addAllMediaFromTokens();

        flash()->success(trans('shops.messages.created'));

        return back();
    }
}

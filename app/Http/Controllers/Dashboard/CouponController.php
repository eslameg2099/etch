<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CouponRequest;
use App\Models\Coupon;
use App\Models\Orders\Order;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::filter()->withCount('orderPayments AS coupon_count')->paginate();
        return view('dashboard.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\CouponRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CouponRequest $request)
    {

        $coupon = Coupon::create($request->all());

        flash()->success(trans('coupons.messages.created'));

        return redirect()->route('dashboard.coupons.show', $coupon);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        return view('dashboard.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('dashboard.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\CouponRequest $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->all());

        flash()->success(trans('coupons.messages.updated'));

        return redirect()->route('dashboard.coupons.show', $coupon);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Coupon $coupon
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        flash()->success(trans('coupons.messages.deleted'));

        return redirect()->route('dashboard.coupons.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $coupons = Coupon::filter()->withCount('orderPayments AS coupon_count')->onlyTrashed()->paginate();
        return view('dashboard.coupons.index', compact('coupons'));
    }

    public function restore(Coupon $coupon)
    {
        $coupon->restore();

        flash()->success(trans('coupons.messages.restored'));

        return redirect()->route('dashboard.coupons.index');
    }
}

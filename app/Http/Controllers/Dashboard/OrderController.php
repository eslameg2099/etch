<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\CustomerCancelOrderEvent;
use App\Events\RateOrderEvent;
use App\Events\UpdateOrderStatusEvent;
use App\Http\Requests\Dashboard\UpdateOrderRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::filterableFilter()->latest('id')->paginate();

        return view('dashboard.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('dashboard.orders.show', compact('order'));
    }
    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('dashboard.orders.edit', compact('order'));
    }
    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $orderRequest,Order $order)
    {
        try {
            $status = $orderRequest->input('status');
            if($status == Order::Delivered) $this->OrderDelivered($order,$status);
            if($status == Order::CanceledBySystem) $this->CanceledBySystem($order,$status);
            flash()->success(trans('orders.messages.updated'));
        }catch (\Exception $e) {
            flash()->error(trans('orders.messages.cannot_edit'));
        }
        return redirect()->route('dashboard.orders.show', $order);
    }
    private function OrderDelivered($order , $status):void
    {
        DB::beginTransaction();
        $order = Order::query()
            ->DeliveryChangeStatus()
            ->whereIn('status', [ Order::UnderDelivery, Order::PaymentDone])
            ->find($order->id);
        if($order) $order->update(['status' => $status]);

        //broadcast(new UpdateOrderStatusEvent($order));

        if ($order->status == Order::Delivered) {

            $order->Delegate->delegate->update(['is_available' => 1]);

            if ($order->payment_type == Order::PAYMENT_ON_DELIVERY) {
                $order->handlePayment();
            }
        }
        DB::commit();
    }
    private function CanceledBySystem($order , $status):void
    {
        $order->forceFill(['status' => $status, 'closed_at' => now()])->save();
        if ($delegate = $order->Delegate) {
            $delegate->delegate->forceFill(['is_available' => 1])->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        $order->delete();

        flash()->success(trans('orders.messages.deleted'));

        return redirect()->route('dashboard.orders.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $orders = Order::filterableFilter()->onlyTrashed()->paginate();

        return view('dashboard.orders.index', compact('orders'));
    }

    public function restore(Order $order)
    {
        $order->restore();

        flash()->success(trans('orders.messages.restored'));

        return redirect()->route('dashboard.orders.index');
    }
}

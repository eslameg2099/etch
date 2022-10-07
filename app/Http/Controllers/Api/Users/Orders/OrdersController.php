<?php

namespace App\Http\Controllers\Api\Users\Orders;

use App\Events\CustomerAcceptOfferEvent;
use App\Events\CustomerCancelOrderEvent;
use App\Events\CustomerChangeDelegateEvent;
use App\Events\CustomerPayOrderEvent;
use App\Events\CustomerRejectOfferEvent;
use App\Events\DelegateAddInvoiceEvent;
use App\Events\Reported;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeDelegateRequest;
use App\Http\Requests\Orders\DeliveryCostRequest;
use App\Http\Requests\Orders\OrderDelegateLastLocationRequest;
use App\Http\Requests\Orders\OrderStoreRequest;
use App\Http\Requests\Payments\PayForOrderRequest;
use App\Http\Requests\Users\AcceptOfferRequest;
use App\Http\Resources\Delegates\OfferResource;
use App\Http\Resources\Orders\OrderResource;
use App\Interfaces\OrdersRepositoryInterface;
use App\Models\Coupon;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use App\Models\Orders\OrderPayment;
use App\Models\Users\User;
use App\Traits\RepositoryResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrdersController extends Controller
{
    use RepositoryResponseTrait;

    private $orderRepo;

    public function __construct(OrdersRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $delivery = Order::query()
            ->where('type', Order::Delivery)
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        $purchase = Order::query()
            ->where('type', Order::Purchase)
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return $this->success([
            'delivery' => OrderResource::collection($delivery),
            'purchase' => OrderResource::collection($purchase),
        ]);
    }
    public function indexPurchased()
    {
        $purchase = Order::query()
            ->where('type', Order::Purchase)
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate();
        return OrderResource::collection($purchase);
    }
    public function indexDelivered()
    {
        $delivery = Order::query()
            ->where('type', Order::Delivery)
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate();

        return OrderResource::collection($delivery);
    }

    public function orderDetails($id)
    {
        $order = Order::query()->with([
            'offers' => function ($q) {
                return $q->when(auth()->check() && auth()->user()->isCustomer(), function ($q) {
                    $q->whereIn('status', [OrderOffer::DelegateAccept, OrderOffer::CustomerAccept]);
                })->when(auth()->check() && auth()->user()->isDelegate(), function ($q) {
                    $q->whereIn('status', [OrderOffer::WaitingDelegateAction]);
                });
            },
        ])->find($id);

        return $order
            ? $this->success([
                'order' => new OrderResource($order),
            ])
            : $this->error(['message' => trans('errors.cannot_find_this_order')]);
    }

    public function store(OrderStoreRequest $request)
    {
        $order = $this->orderRepo->createOrder($request);

        return $order instanceof Order ? response()->json([
            'order' => new OrderResource($order),
            'private_channel' => 'order-'.$order->reference_number,
        ]) : $order;
    }
    public function deliveryCost(DeliveryCostRequest $request)
    {
        $cost = $this->orderRepo->getDeliveryCost($request);
        return $cost
            ? $this->success(['delivery_cost' => price($cost)])
            : $this->error(['message' => trans('errors.cannot_decide_location')]);
    }

    public function show($id)
    {
        $order = $this->orderRepo->getOrderById($id);

        return $order
            ? $this->success(['order' => new OrderResource($order)])
            : $this->error(['message' => trans('errors.cannot_find_this_order')]);
    }

    public function acceptOffer(AcceptOfferRequest $request)
    {
        DB::beginTransaction();
        try {
            $offer = OrderOffer::query()
                ->where('id', $request->input('offer_id'))
                ->where('status', OrderOffer::DelegateAccept)
                ->first();

            if (! $offer) {
                return $this->error(['message' => trans('errors.cannot_find_this_offer')]);
            }

            $order = $offer->order;
            $offer->update(['status' => OrderOffer::CustomerAccept, 'accepted_at' => Carbon::now()]);

            $order->offers()->where('id', '!=',
                $request->input('offer_id'))->update(['status' => OrderOffer::CustomerReject]);

            // TODO: fix this Habda
            OrderOffer::where('delegate_id', $offer->delegate_id)
                ->where('status', OrderOffer::DelegateAccept)
                ->where('id', '!=', $request->input('offer_id'));

            // Delete Delegate's offers
            OrderOffer::where('delegate_id', $offer->delegate_id)
                ->where('id', '!=', $offer->id)
                ->where('status', '!=', OrderOffer::CustomerAccept)
                ->delete();

            $order->update([
                'delegate_id' => $offer->delegate_id,
                'start_at' => Carbon::now(),
                'status' => $order->type == Order::Delivery ? Order::WaitingForPayment : Order::WaitingForAddPayment,
            ]);

            $offer->delegate->delegate->update(['is_available' => 0]);

            $order->offers()->where('status', OrderOffer::CustomerReject)->get()->each(function ($offer) use ($order) {
                broadcast(new CustomerRejectOfferEvent($order, $offer));
            });

            broadcast(new CustomerAcceptOfferEvent($offer));

            if ($order->type == Order::Delivery) {
                broadcast(new DelegateAddInvoiceEvent($order));
            }

            DB::commit();

            return $this->success([
                'message' => trans('global.offer_accepted'),
                'offer' => new OfferResource($offer),
                'order' => new OrderResource($order->refresh()),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->serverError([
                'message' => trans('errors.some_thing_happened'),
                'server_error' => $e->getMessage(),
            ]);
        }
    }

    public function changeDelegate(ChangeDelegateRequest $request)
    {
        /** @var \App\Models\Users\User $user */
        $user = auth()->user();
        /** @var Order $order */
        $order = Order::query()
            ->where('user_id', $request->user()->id)
            ->whereIn('status', [Order::WaitingForPayment, Order::WaitingForAddPayment])
            ->findOrFail($request->input('order_id'));

        if (! $user->canUndo($order) && ! $request->input('force')) {
            return response()->json([
                'message' => trans('errors.cannot_change_delegate_after_5_min', [
                    'minutes' => $user->getCancellationGracePeriod(),
                    'attempts' => $user->cancellation_attempts,
                ]),
            ]);
        }

        if (! $user->canUndo($order)) {
            $user->newQuery()->where('id', $user->id)->decrement('cancellation_attempts');
        }

        OrderOffer::where('order_id', $order->id)->forceDelete();

        $this->orderRepo->changeDelegate($order);

        broadcast(new CustomerChangeDelegateEvent($order));

        return response()->json([
            'order' => new OrderResource($order),
            'private_channel' => 'order-'.$order->reference_number,
        ]);
    }

    public function payForOrder(PayForOrderRequest $request)
    {
        DB::beginTransaction();
        /** @var Order $order */
        $order = $this->orderRepo->getOrderById($request->input('order_id'));

        if ($order->payment_type == Order::ONLINE_PAYMENT) {
            $request->validate([
                'checkout_id' => 'required|exists:checkouts,checkout_id',
            ]);
        }
        if ($order->payment_type == Order::PAYMENT_FROM_WALLET && $order->User->getBalance() < $order->payment->getTotal()) {
            throw ValidationException::withMessages([
                'amount' => trans('transactions.errors.order.not-enough'),
            ]);
        }

        if (! $order) {
            return $this->error(['message' => trans('errors.cannot_find_this_order')]);
        }

        if ($order->payment_type != Order::PAYMENT_ON_DELIVERY) {
            $order->handlePayment($request->checkout_id);
        }


        $order->payment->update(['status' => OrderPayment::Accepted]);
        $order->update(['status' => Order::PaymentDone]);

        DB::commit();

        broadcast(new CustomerPayOrderEvent($order));

        return $this->success([
            'message' => trans('global.operation_succeeded'),
            'order' => new OrderResource($order->refresh()),
        ]);
    }

    public function getDelegateLastLocation(OrderDelegateLastLocationRequest $request)
    {
        $order = Order::query()->find($request->input('order_id'));
        if ($order && $order->Delegate) {
            return response()->json([
                'lat' => $order->Delegate->lat,
                'long' => $order->Delegate->lng,
            ]);
        }

        return response()->json([
            'lat' => 0,
            'long' => 0,
        ]);
    }

    public function report(Request $request, Order $order)
    {
        $request->validate(['message' => 'required']);

        if (! $order->Delegate) {
            abort(403, 'Order doesn\'t have delegate.');
        }

        $report = $order->reports()->create([
            'user_id' => $order->user_id,
            'delegate_id' => $order->delegate_id,
            'message' => $request->message,
        ]);

        event(new Reported($report));

        return response()->json([
            'message' => __('Reported'),
        ]);
    }

    /**
     * Rate the given order.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Orders\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function rate(Request $request, Order $order)
    {
        if ($order->status != Order::Delivered) {
            throw ValidationException::withMessages([
                'rate' => [__('Cannot rate this order!')],
            ]);
        }

        $request->validate([
            'rate' => 'required|numeric|between:1,5',
            'comment' => 'required|string',
        ]);

        $order->rates()->updateOrCreate([
            'user_id' => auth()->id(),
        ], [
            'user_id' => auth()->id(),
            'rate' => $request->input('rate'),
            'comment' => $request->input('comment'),
        ]);


        return response()->json(['message' => __('Rated.')]);
    }

    public function start(Order $order)
    {
        $this->orderRepo->startOrder($order);

        return response()->json([
            'order' => new OrderResource($order->refresh()),
        ]);
    }

    public function cancel(Order $order)
    {
        if (in_array($order->status, [
            Order::PaymentDone,
            Order::UnderReview,
            Order::UnderDelivery,
            Order::Delivered,
        ])) {
            abort(403, __('لايمكنك الغاء هذا الطلب'));
        }
        $order = $this->orderRepo->cancelOrder($order);

        //TODO: send push notification to delegate @belal
        broadcast(new CustomerCancelOrderEvent($order));
        return response()->json([
            'order' => new OrderResource($order->refresh()),
        ]);
    }

    public function applyCoupon(Request $request, Order $order)
    {
        $request->validate(['code' => 'required|exists:coupons,code']);

        $coupon = Coupon::where('code', $request->code)->firstOrFail();

        if (! $order->payment) {
            throw ValidationException::withMessages([
                'payment' => [__('لا يمكن استخدام الكوبون قبل انشاء الفاتورة')],
            ]);
        }

        if ($coupon->usage_count <= OrderPayment::where('coupon_id', $coupon->id)->count()) {
            throw ValidationException::withMessages([
                'payment' => [__('هذا الكوبون مستخدم من قبل.')],
            ]);
        }
        if ( $coupon->only_once &&
            Order::where('user_id',auth()->id())->whereHas('payment', function ($query) use($coupon){
                return $query->where('coupon_id',$coupon->id);
            })->count() >= 1 ) {
            throw ValidationException::withMessages([
                'payment' => [__('هذا الكوبون مستخدم من قبل.')],
            ])->status(422);
        }

        if ( $coupon->only_new &&
            Order::where('user_id',auth()->id())->where('status',Order::Delivered)->count() >= 1
        ) {
            throw ValidationException::withMessages([
                'payment' => [__('هذا الكوبون للعملاء الجدد فقط.')],
            ])->status(422);
        }

        $order->payment->forceFill(['coupon_id' => $coupon->id])->save();

        return response()->json([
            'order' => new OrderResource($order->refresh()),
        ]);
    }
}

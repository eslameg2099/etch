<?php

namespace App\Http\Controllers\Api\Delegates;

use App\Events\DelegateAddInvoiceEvent;
use App\Events\DelegateWithdrawalEvent;
use App\Events\NewOrderOfferEvent;
use App\Events\RateOrderEvent;
use App\Events\UpdateOrderStatusEvent;
use App\Http\Controllers\Controller;
use App\Http\Filters\ModelFilter\OrderModelFilter;
use App\Http\Requests\Delegate\AcceptOrderRequest;
use App\Http\Requests\Delegates\InvoiceRequest;
use App\Http\Requests\Delegates\UpdateOrderStatusReqest;
use App\Http\Requests\Delegates\UpdateOrderStatusRequest;
use App\Http\Requests\Delegates\withdrawalFromOrderRequest;
use App\Http\Resources\DelegateResource;
use App\Http\Resources\Delegates\OfferResource;
use App\Http\Resources\Orders\OrderResource;
use App\Interfaces\OrdersRepositoryInterface;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use App\Traits\RepositoryResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $orders = Order::query()
            ->filter(new OrderModelFilter(\request()))
            ->myOrders()
            ->latest()
            ->simplePaginate();

        return $this->success([
            'orders' => OrderResource::collection($orders),
            'hasNext' => $orders->hasMorePages(),
            'currentPage' => $orders->currentPage(),
        ]);
    }

    /**
     * @deprecated
     * @return \Illuminate\Http\JsonResponse
     */
    public function newOrders()
    {
        $orders = Order::query()
            ->whereHas('offers', function ($q) {
                return $q->NewDelegateOrders();
            })
            ->with([
                'offers' => function ($q) {
                    return $q->NewDelegateOrders();
                },
            ])
            ->get();

        return response()->json(['orders' => OrderResource::collection($orders)]);
    }

    public function acceptOrder(AcceptOrderRequest $request)
    {
        $offer = OrderOffer::query()
            ->where('delegate_id', $request->user()->id)
            ->where('status', OrderOffer::WaitingDelegateAction)
            ->where('order_id', $request->input('order_id'))
            ->first();

        if (! $offer) {
            return response()->json(['message' => trans('errors.cannot_set_offer_on_this_order')], 422);
        }

        $offer->update(['status' => OrderOffer::DelegateAccept]);

        broadcast(new NewOrderOfferEvent($offer));

        return response()->json([
            'message' => trans('global.offer_has_been_set'),
            'offer' => new OfferResource($offer),
            'order' => new OrderResource($offer->order->refresh()),
        ]);
    }

    public function withdrawalFromOrder(withdrawalFromOrderRequest $request)
    {
        /** @var \App\Models\Users\User $user */
        $user = auth()->user();
        $order = Order::query()
            ->whereNotIn('status', [
                Order::PaymentDone,
                Order::UnderDelivery,
                Order::Delivered,
                Order::UnderReview,
            ])
            ->whereNull('closed_at')
            ->with([
                'offers' => function ($q) {
                    return $q->DelegateCanWithdrawal();
                },
            ])
            ->findOrFail($request->order_id);
        // return warning about attemps, then receive force input.
        if ($order->delegate_id == $user->id && ! $user->canUndo($order) && ! $request->input('force')) {
            return response()->json([
                'message' => trans('errors.cannot_withdrawal_after_180', [
                    'minutes' => $user->getCancellationGracePeriod(),
                    'attempts' => $user->cancellation_attempts,
                ]),
            ]);
        }

        if (! $user->canUndo($order)) {
            $user->newQuery()->where('id', $user->id)->decrement('cancellation_attempts');
        }

        if ($order->delegate_id == $user->id) {
            OrderOffer::where('order_id', $order->id)->forceDelete();
            $this->orderRepo->changeDelegate($order);
        } else {
            OrderOffer::where('order_id', $order->id)->where('delegate_id', $user->id)->update(['status' => OrderOffer::WaitingDelegateAction]);
        }
        // Should be on Client Accepted Case Only. -- in condition above
        broadcast(new DelegateWithdrawalEvent($order, $user));

        return $this->success([
                'message' => trans('global.delegate_withdrawal_success'),
                'order' => new OrderResource($order->refresh()),
            ]
        );
    }

    public function invoice(InvoiceRequest $request)
    {
        $order = Order::query()->find($request->input('order_id'));

        $orderFactory = $order->getFactory();
        DB::beginTransaction();
        try {
            $orderFactory->createInvoice();
            DB::commit();

            return $this->success([
                'message' => trans('global.operation_succeeded'),
                'order' => new OrderResource($order->fresh()),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error(['message' => $e->getMessage()]);
        }
    }

    public function updateOrderStatus(UpdateOrderStatusRequest $request)
    {
        DB::beginTransaction();
        $order = Order::query()
            ->DeliveryChangeStatus()
            ->whereIn('status', [Order::UnderReview, Order::UnderDelivery, Order::PaymentDone])
            ->find($request->input('order_id'));


        $order->update(['status' => $request->input('status')]);

        broadcast(new UpdateOrderStatusEvent($order));

        if ($order->status == Order::Delivered) {

            $order->Delegate->delegate->update(['is_available' => 1]);

            if ($order->payment_type == Order::PAYMENT_ON_DELIVERY) {
                $order->handlePayment();
            }
            event(new RateOrderEvent($order));
        }
        DB::commit();
        return $this->success([
            'message' => trans('global.operation_succeeded'),
            'order' => new OrderResource($order),
        ]);
    }
}

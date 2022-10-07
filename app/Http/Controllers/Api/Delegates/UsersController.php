<?php

namespace App\Http\Controllers\Api\Delegates;

use App\Events\NewOrderOfferEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Delegate\AcceptOrderRequest;
use App\Http\Requests\Delegate\StoreDelegateRequest;
use App\Http\Requests\Delegate\UpdateDelegateRequest;
use App\Http\Requests\Users\StoreDelegateLastLocationRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\UserResource;
use App\Interfaces\OrdersRepositoryInterface;
use App\Interfaces\UsersRepositoryInterface;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOffer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laraeast\LaravelSettings\Facades\Settings;

class UsersController extends Controller
{
    private $userRepo;

    public function __construct(UsersRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function store(StoreDelegateRequest $request)
    {
        $user = $this->userRepo->storeOrUpdateUser($request);

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken($request->device_name)->plainTextToken,
        ]);
    }

    public function update(UpdateDelegateRequest $request)
    {
        if ($request->can_receive_cash_orders
            && auth()->user()->getBalance() < Settings::get('delegate_hold_amount', 0)) {
            throw ValidationException::withMessages([
                'can_receive_cash_orders' => [trans('transactions.errors.cash.not-enough')],
            ]);
        }
        $user = $this->userRepo->storeOrUpdateUser($request, $request->user()->id);

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    public function receiveCashOrders(Request $request)
    {
        if ($request->can_receive_cash_orders
            && auth()->user()->getBalance() < Settings::get('delegate_hold_amount', 0)) {
            throw ValidationException::withMessages([
                'can_receive_cash_orders' => [trans('transactions.errors.cash.not-enough')],
            ]);
        }
        auth()->user()->delegate->forceFill(['can_receive_cash_orders' => ! ! $request->can_receive_cash_orders])->save();

        return response()->json([
            'user' => new UserResource(auth()->user()->refresh()),
        ]);
    }

    public function toggleAvailable(Request $request)
    {

        if (! $request->user()->delegate) {
            abort(404);
        }

        // Has in progress orders.
        if (! $request->user()->delegate->is_available // is_available = 0 Then True
            &&
            Order::where('delegate_id', $request->user()->id)->whereNull('closed_at')->exists())  // closed_at then true
        {
            throw ValidationException::withMessages([
                'is_available' => [__('لا يمكن استقبال طلبات في حال اذا كان لديك طلب جاري')],
            ]);
        }

        $request->user()->delegate->forceFill(['is_available' => ! $request->user()->delegate->is_available])->save();

        return response()->json([
            'user' => new UserResource(auth()->user()->refresh()),
        ]);
    }

    public function lastLocation(StoreDelegateLastLocationRequest $request)
    {
        return $this->userRepo->StoreDelegateLastLocation($request);
    }
}

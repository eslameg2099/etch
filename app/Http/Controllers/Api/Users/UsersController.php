<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\ShopResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UsersRepositoryInterface;
use App\Models\Shop;
use App\Models\Users\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $userRepo;

    public function __construct(UsersRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }
// Register Method
    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepo->storeOrUpdateUser($request);

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken($request->device_name)->plainTextToken,
        ]);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $this->userRepo->storeOrUpdateUser($request, $request->user()->id);

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    public function favorites()
    {
        /** @var User $user */
        $user = auth()->user();

        $shops = $user->favorite(Shop::class);

        return ShopResource::collection($shops);
    }
}

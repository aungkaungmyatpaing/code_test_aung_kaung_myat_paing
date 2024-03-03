<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    use ApiResponse;

    private UserService $userService;
    private OrderService $orderService;

    public function __construct(UserService $userService, OrderService $orderService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
    }

    public function register(UserRegisterRequest $request)
    {
        $token = $this->userService->register($request->validated());
        return $this->success('Create account successful', [
            'token' => $token,
        ]);
    }

    public function login(UserLoginRequest $request)
    {
        $token = $this->userService->login($request->validated());
        return $this->success('Login successful', [
            'token' => $token,
        ]);
    }

    public function getUserProfile()
    {
        $user = $this->userService->getUserProfile();
        $orders = $this->orderService->getOrderHistories();
        $data = [
            'user' => new UserResource($user),
            'orders' => OrderResource::collection($orders),
        ];
        return $this->success('Get user profile successful', $data);
    }

    public function logout()
    {
        $this->userService->logout();
        return $this->success('Logout successful');
    }
}

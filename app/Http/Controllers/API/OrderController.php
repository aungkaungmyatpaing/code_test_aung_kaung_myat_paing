<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getOrderHistories()
    {
        $orderHistories = $this->orderService->getOrderHistories();
        return $this->success('Get order histories successfully', OrderResource::collection($orderHistories));
    }

    public function getOrderDetail($id)
    {
        $order = $this->orderService->getOrderDetail($id);
        return $this->success('Get order detail successfully', new OrderDetailResource($order));
    }
}

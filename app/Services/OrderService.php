<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getOrderHistories(): Collection
    {
        $user = Auth::guard('user')->user();
        $orders = $user->orders;

        return $orders;
    }

    public function getOrderDetail($id): Order
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('user')->user();
        $order = $user->orders()->findOrFail($id);

        return $order;
    }
}

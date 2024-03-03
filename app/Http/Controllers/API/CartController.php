<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;

    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart(AddToCartRequest $request)
    {
        $this->cartService->addToCart($request->validated());
        return $this->success('Added to cart successfully');
    }

    public function getCarts()
    {
        $carts = $this->cartService->getCarts();
        return $this->success('Get carts successfully', CartResource::collection($carts));
    }

    public function updateCart(UpdateCartRequest $request, int $id)
    {
        $this->cartService->updateCart($request->validated(), $id);
        return $this->success('Cart updated successfully');
    }

    public function deleteCart(int $id)
    {
        $this->cartService->deleteCart($id);
        return $this->success('Cart deleted successfully');
    }
}

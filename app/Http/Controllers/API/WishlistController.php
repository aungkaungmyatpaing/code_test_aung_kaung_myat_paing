<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToWishlistRequest;
use App\Http\Resources\WishlistResource;
use App\Services\WishlistService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    use ApiResponse;

    private WishlistService $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function toggleWishlist(AddToWishlistRequest $request)
    {
        $message = $this->wishlistService->toggleWishlist($request->validated());
        return $this->success($message);
    }

    public function getWishlist()
    {
        $wishlist = $this->wishlistService->getWishlist();
        return $this->success('Get wishlist successful', WishlistResource::collection($wishlist));
    }
}

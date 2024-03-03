<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\DeliveryController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', [UserAuthController::class, 'register']);
Route::post('/user/login', [UserAuthController::class, 'login']);

Route::get('/authors', [BookController::class, 'getAuthors']);
Route::get('/genres', [BookController::class, 'getGenres']);
Route::get('/books', [BookController::class, 'getBooks']);
Route::get('/books/{id}/detail', [BookController::class, 'getBookDetail']);

Route::get('/delivery/regions', [DeliveryController::class, 'getRegions']);
Route::get('/delivery/region/{id}/townships', [DeliveryController::class, 'getTownships']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [UserAuthController::class, 'getUserProfile']);
    Route::post('/user/logout', [UserAuthController::class, 'logout']);

    Route::post('/toggle-wishlist', [WishlistController::class, 'toggleWishlist']);
    Route::get('/wishlist', [WishlistController::class, 'getWishlist']);

    Route::post('add-to-cart', [CartController::class, 'addToCart']);
    Route::get('carts', [CartController::class, 'getCarts']);
    Route::put('carts/{id}/update', [CartController::class, 'updateCart']);
    Route::delete('carts/{id}/delete', [CartController::class, 'deleteCart']);

    Route::get('/payment-methods', [PaymentController::class, 'getPaymentMethods']);
    Route::get('/payment-methods/{id}/payment-accounts', [PaymentController::class, 'getPaymentAccounts']);

    Route::get('/checkout-preview', [CheckoutController::class, 'checkoutPreview']);
    Route::post('/checkout', [CheckoutController::class, 'checkout']);

    Route::get('/order-history', [OrderController::class, 'getOrderHistories']);
    Route::get('/order-history/{id}/detail', [OrderController::class, 'getOrderDetail']);
});

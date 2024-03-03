<?php

namespace App\Services;

use App\Exceptions\CreateDataFailException;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CartService
{
    public function addToCart(array $requestBody)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::guard('user')->user();
        $book = Book::findOrFail($requestBody['book_id']);
        $bookStock = $book->stock;

        $oldCart = $user->carts()->where('book_id', $requestBody['book_id'])->first();
        if ($oldCart) {
            if ($oldCart->quantity + $requestBody['quantity'] > $bookStock) {
                throw new CreateDataFailException('Book is out of stock');
            }
            try {
                $oldCart->quantity += $requestBody['quantity'];
                $oldCart->save();
            } catch (\Throwable $th) {
                throw new CreateDataFailException('Failed to add to cart');
            }
        } else {
            if ($requestBody['quantity'] > $bookStock) {
                throw new CreateDataFailException('Book is out of stock');
            }
            try {
                $user->carts()->create([
                    'book_id' => $requestBody['book_id'],
                    'quantity' => $requestBody['quantity'],
                ]);
            } catch (\Throwable $th) {
                throw new CreateDataFailException('Failed to add to cart');
            }
        }
    }

    public function getCarts()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::guard('user')->user();
        return $user->carts;
    }

    public function updateCart(array $requestBody, int $id)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::guard('user')->user();
        $cart = $user->carts()->findOrFail($id);
        $bookStock = $cart->book->stock;

        if ($requestBody['quantity'] > $bookStock) {
            throw new CreateDataFailException('Book is out of stock');
        }

        try {
            $cart->quantity = $requestBody['quantity'];
            $cart->save();
        } catch (\Throwable $th) {
            throw new CreateDataFailException('Failed to update cart');
        }
    }

    public function deleteCart(int $id)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::guard('user')->user();
        $cart = $user->carts()->findOrFail($id);
        try {
            $cart->delete();
        } catch (\Throwable $th) {
            throw new CreateDataFailException('Failed to delete cart');
        }
    }
}

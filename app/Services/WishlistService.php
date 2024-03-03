<?php

namespace App\Services;

use App\Exceptions\CreateDataFailException;
use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistService
{
    public function toggleWishlist(array $requestBody): string
    {
        try {
            /** @var \App\Models\User $user **/
            $user = Auth::guard('user')->user();

            $oldWishlist = $user->wishlist()->where('book_id', $requestBody['book_id'])->first();

            if ($oldWishlist) {
                $oldWishlist->delete();
                return 'Book removed from wishlist';
            } else {
                $user->wishlist()->create([
                    'book_id' => $requestBody['book_id']
                ]);
                return 'Book added to wishlist';
            }
        } catch (\Throwable $th) {
            throw new CreateDataFailException('Failed to add to wishlist');
        }
    }

    public function getWishlist()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::guard('user')->user();
        $wishlist = $user->wishlist;
        return $wishlist;
    }
}

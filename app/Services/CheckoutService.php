<?php

namespace App\Services;

use App\Exceptions\CreateDataFailException;
use App\Exceptions\UnprocessableRequestException;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckoutService
{
    public function getCheckoutPreview(): array
    {
        $user = Auth::guard('user')->user();
        $carts = $user->carts;

        $total = 0;
        $tax = 200;

        foreach ($carts as $cart) {
            $total += $cart->book->price * $cart->quantity - ($cart->book->price * $cart->quantity * $cart->book->discount / 100);
        }

        $data = [
            'carts' => $carts,
            'total' => $total,
            'tax' => $tax,
            'grand_total' => $total + $tax,
        ];

        return $data;
    }

    public function checkout(array $requestData)
    {
        if (!$requestData['cod']) {
            if (!array_key_exists('payment_account_id', $requestData) || !array_key_exists('slip', $requestData)) {
                throw new ValidationException('Payment informations are required');
            }
        }
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::guard('user')->user();
        $carts = $user->carts;

        if ($carts->isEmpty()) {
            throw new UnprocessableRequestException('Checkout failed, cart is empty');
        }

        $total = 0;
        $tax = 200;

        DB::beginTransaction();
        try {
            foreach ($carts as $cart) {
                $total += $cart->book->price * $cart->quantity - ($cart->book->price * $cart->quantity * $cart->book->discount / 100);
            }

            $grandTotal = $total + $tax;

            $order = $user->orders()->create([
                'phone' => $requestData['phone'],
                'township_id' => $requestData['township_id'],
                'address' => $requestData['address'],
                'cod' => $requestData['cod'],
                'payment_account_id' => $requestData['cod'] ? null : $requestData['payment_account_id'],
                'total' => $total,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'note' => $requestData['note'] ?? '',
            ]);

            if (array_key_exists('slip', $requestData) && !$requestData['cod']) {
                $slip = $requestData['slip'];
                try {
                    $slipname = $this->generateUniqueFilename($slip);
                    $order->addMedia($slip)
                        ->usingFileName($slipname)
                        ->toMediaCollection('slip');
                } catch (\Exception $e) {
                    throw new CreateDataFailException('Checkout failed, slip upload failed');
                }
            }

            foreach ($carts as $cart) {
                $order->orderBooks()->create([
                    'user_id' => $user->id,
                    'book_id' => $cart->book_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->book->price,
                    'discount' => $cart->book->discount,
                    'total_price' => $cart->book->price * $cart->quantity - ($cart->book->price * $cart->quantity * $cart->book->discount / 100),
                ]);
            }
            $user->carts()->delete();

            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new CreateDataFailException('Checkout failed : ' . $th->getMessage());
        }
    }


    public static function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->extension();
        $filename =  uniqid() . '.' . $extension;

        while (Storage::disk('public')->exists($filename)) {
            $filename =  uniqid() . '.' . $extension;
        }

        return $filename;
    }
}

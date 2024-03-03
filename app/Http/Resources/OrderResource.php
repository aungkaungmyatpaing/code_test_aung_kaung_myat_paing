<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'tax' => $this->tax,
            'grand_total' => $this->grand_total,
            'status' => $this->status,

            'phone' => $this->phone,
            'township' => $this->township->name,
            'address' => $this->address,
            'note' => $this->note,

            'cod' => $this->cod,
            'payment_account' => $this->cod ? null : new PaymentAccountResource($this->paymentAccount),
            'slip' => $this->cod ? null : $this->getFirstMediaUrl('slip'),

            'book_count' => $this->orderBooks->count(),

            'created_at' => $this->created_at,
        ];
    }
}

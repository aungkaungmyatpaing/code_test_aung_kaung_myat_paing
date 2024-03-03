<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'note' => $this->note,
            'created_at' => $this->created_at,

            'books' => OrderBookResource::collection($this->orderBooks),

            'payment_informations' => [
                'cod' => $this->cod,
                'payment_method' => $this->cod ? null : new PaymentMethodResource($this->paymentAccount->paymentMethod),
                'payment_account' => $this->cod ? null : new PaymentAccountResource($this->paymentAccount),
                'slip' => $this->cod ? null : $this->getFirstMediaUrl('slip'),
            ],

            'delivery_informations' => [
                'phone' => $this->phone,
                'township' => new TownshipResource($this->township),
                'address' => $this->address,
            ],
        ];
    }
}

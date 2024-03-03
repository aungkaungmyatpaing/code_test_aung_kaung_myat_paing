<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'book_id' => $this->book_id,
            'name' => $this->book->name,
            'author' => $this->book->author->name,
            'genre' => $this->book->genre->name,
            'price' => $this->book->price,
            'thumbnail' => $this->book->getFirstMediaUrl('book-cover', 'thumb'),
            'quantity' => $this->quantity,
            'discount' => $this->book->discount,
            'discount_price' => $this->book->price * $this->quantity * $this->book->discount / 100,
            'total' => $this->book->price * $this->quantity - ($this->book->price * $this->quantity * $this->book->discount / 100),
            'created_at' => $this->created_at,
        ];
    }
}

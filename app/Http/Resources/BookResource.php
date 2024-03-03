<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'name' => $this->name,
            'author' => $this->author->name,
            'genre' => $this->genre->name,
            'price' => $this->price,
            'discount' => $this->discount,
            'thumbnail' => $this->getFirstMediaUrl('book-cover', 'thumb'),
            'created_at' => $this->created_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookDetailResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'discount' => $this->discount,
            'stock' => $this->stock,
            'images' => $this->getAllImages(),
            'created_at' => $this->created_at,

            'author' => new AuthorResource($this->author),
            'genre' => new GenreResource($this->genre),
        ];
    }

    private function getAllImages(): array
    {
        $imageList = [];
        foreach ($this->getMedia('book-cover') as $image) {
            $imageList[] = $image->getUrl();
        }

        if (count($imageList) < 1) {
            $imageList[] = asset('assets/images/default.png');
        }
        return $imageList;
    }
}

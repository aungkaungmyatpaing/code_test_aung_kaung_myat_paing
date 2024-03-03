<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetBooksRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookDetailResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\GenreResource;
use App\Services\BookService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ApiResponse;

    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function getBooks(GetBooksRequest $request)
    {
        $books = $this->bookService->getBooks($request->validated());
        // return $this->success("Get books successful", $books);
        $data = [
            'books' => BookResource::collection($books),
            'meta' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'total' => $books->total(),
                'per_page' => $books->perPage(),
            ],
        ];

        return $this->success("Get books successful", $data);
    }

    public function getBookDetail($id)
    {
        $book = $this->bookService->getBookDetail($id);
        return $this->success("Get book detail successful", new BookDetailResource($book));
    }

    public function getAuthors()
    {
        $authors = $this->bookService->getAuthors();
        return $this->success("Get authors successful", AuthorResource::collection($authors));
    }

    public function getGenres()
    {
        $genres = $this->bookService->getGenres();
        return $this->success("Get genres successful", GenreResource::collection($genres));
    }
}

<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    public function getBooks($filter): LengthAwarePaginator
    {
        $query = Book::query()
            ->when(isset($filter['author']), function ($q) use ($filter) {
                $q->where('author_id', $filter['author']);
            })
            ->when(isset($filter['genre']), function ($q) use ($filter) {
                $q->where('genre_id', $filter['genre']);
            })
            ->when(isset($filter['keyword']), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('name', 'like', '%' . $filter['keyword'] . '%')
                        ->orWhere('description', 'like', '%' . $filter['keyword'] . '%');
                });
            });

        $perPage = $filter['limit'] ?? 20;
        $books = $query->paginate($perPage);
        return $books;
    }

    public function getBookDetail(int $bookId): Book
    {
        return Book::findOrFail($bookId);
    }

    public function getAuthors()
    {
        $authors = Author::all();
        return $authors;
    }

    public function getGenres()
    {
        $genres = Genre::all();
        return $genres;
    }
}

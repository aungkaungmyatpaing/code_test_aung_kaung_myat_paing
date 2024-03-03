<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Region;
use App\Models\Township;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(AdminSeeder::class);
        $this->call(AuthorSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(PaymentAccountSeeder::class);


        /**
         * Seed the books
         */
        $books = json_decode(file_get_contents(public_path('data/books.json')));
        foreach ($books->books as $book) {
            $bookModel = new Book();
            $bookModel->name = $book->name;
            $bookModel->description = $book->description;
            $bookModel->author_id = rand(1, 3);
            $bookModel->genre_id = rand(1, 3);
            $bookModel->price = rand(5000, 20000);
            $bookModel->discount = rand(0, 20);
            $bookModel->stock = rand(0, 100);
            $bookModel->is_public = true;
            $bookModel->created_at = now();
            $bookModel->updated_at = now();
            $bookModel->save();
        }


        /**
         * Seed the regions and townships
         */
        $regions = json_decode(file_get_contents(public_path('data/myanmar.json')));
        foreach ($regions->data as $region) {
            $regionModel = new Region();
            $regionModel->name = $region->eng;
            $regionModel->save();
            foreach ($region->districts as $district) {

                foreach ($district->townships as $township) {
                    $townshipModel = new Township();
                    $townshipModel->name = $township->eng;
                    $townshipModel->region_id = $regionModel->id;
                    $townshipModel->delivery_fee = 4000;
                    $townshipModel->duration = 3;
                    $townshipModel->remark = "Just a note";
                    $townshipModel->save();
                }
            }
        }
    }
}

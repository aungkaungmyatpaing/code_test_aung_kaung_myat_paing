<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'J. K. Rowling',
                'description' => 'Joanne Rowling CH OBE FRSL, better known by her pen name J. K. Rowling, is a British author and philanthropist.',
            ],
            [
                'name' => 'Stephen King',
                'description' => 'Stephen Edwin King is an American author of horror, supernatural fiction, suspense, crime, science-fiction, and fantasy novels.',
            ],
            [
                'name' => 'George R. R. Martin',
                'description' => 'George Raymond Richard Martin, also known as GRRM, is an American novelist and short story writer in the fantasy, horror, and science fiction genres.',
            ],
        ];

        DB::table('authors')->insert($authors);
    }
}

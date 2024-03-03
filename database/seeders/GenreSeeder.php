<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            [
                'name' => 'Fantasy',
                'description' => 'Fantasy is a genre of speculative fiction set in a fictional universe, often inspired by real world myth and folklore.',
            ],
            [
                'name' => 'Horror',
                'description' => 'Horror is a genre of speculative fiction which is intended to frighten, scare, or disgust.',
            ],
            [
                'name' => 'Science Fiction',
                'description' => 'Science fiction is a genre of speculative fiction that typically deals with imaginative and futuristic concepts such as advanced science and technology, space exploration, time travel, parallel universes, and extraterrestrial life.',
            ],
        ];

        DB::table('genres')->insert($genres);
    }
}

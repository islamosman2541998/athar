<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categories::factory()->count(5)->create();
        // Categories::factory()->count(100)->create();
        // Categories::factory()->count(100)->create();
        // Categories::factory()->count(300)->create();

    }
}

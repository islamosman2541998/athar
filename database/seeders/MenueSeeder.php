<?php

namespace Database\Seeders;

use App\Models\Menue;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menue::factory()->count(5)->create();
        Menue::factory()->count(10)->create();
        Menue::factory()->count(100)->create();
        Menue::factory()->count(100)->create();
        // Menue::factory()->count(100)->create();
        // Menue::factory()->count(200)->create();
    }
}

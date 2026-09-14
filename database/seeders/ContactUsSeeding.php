<?php

namespace Database\Seeders;

use App\Models\Contactus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactUsSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Contactus::factory()->count(20)->create();
    }
}

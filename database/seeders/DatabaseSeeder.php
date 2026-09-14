<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\ThemesSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\ServicesSeeder;
use Database\Seeders\ContactUsSeeding;
use Database\Seeders\HomeSettingPageSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ThemesSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(SuperAdminSeeder::class);
        $this->call(PagesSeeding::class);
        $this->call(HomeSettingPageSeeder::class);
        $this->call(SiteSeeder::class);
        $this->call(AtharHomeSectionsSeeder::class);


        // $this->call(ArticlesSeeding::class);
        // $this->call(MenueSeeder::class);
        // $this->call(ContactUsSeeding::class);
        // $this->call(CategoriesSeeder::class);
        // $this->call(ServicesSeeder::class);


     
    }
}

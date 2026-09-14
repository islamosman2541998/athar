<?php

namespace Database\Seeders;

use App\Models\HomeSettingPage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HomeSettingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title_settings = [
            'Home',
            'about',
            'vision',
            'mission',
            'goals',
            'Brand',
            'portfolio',
            'loyalty program',
            'services',
            'contact-us',
            'blogs',
        ];

        foreach ($title_settings as $title) {
            foreach (config('translatable.locales') as $locale) {
                $dataTrans[$locale]['title'] = '<span>' . $title . '</span>';
                $dataTrans[$locale]['sub_title'] = $title;
                $dataTrans[$locale]['description'] = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit praesentium blanditiis dolore repellat quam! Minima corporis corrupti blanditiis est in, atque excepturi, ipsam voluptate molestiae dignissimos magni recusandae praesentium modi.';
            }

            HomeSettingPage::create(['title_section' => $title] + $dataTrans);
        }
    }
}

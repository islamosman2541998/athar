<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\News;
use App\Models\Menue;
use App\Models\Slider;
use App\Models\Articles;
use App\Models\Services;
use App\Models\Categories;
use App\Models\Portfolios;
use App\Models\ArticleTags;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Pluralizer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menues')->delete();
        DB::table('menue_translations')->delete();
        DB::table('sliders')->delete();
        DB::table('slider_translations')->delete();
        DB::table('news')->delete();
        DB::table('news_translations')->delete();
        DB::table('tags')->delete();
        DB::table('tag_translations')->delete();
        DB::table('portfolios')->delete();
        DB::table('portfolios_translations')->delete();
        DB::table('categories')->delete();
        DB::table('categories_translations')->delete();
        DB::table('articles')->delete();
        DB::table('article_translations')->delete();
        DB::table('services')->delete();
        DB::table('services_translations')->delete();

        // create Offers

        $title_section = [
            'Home',
            'About',
            'Services',
            'Portfolio',
            'Loyalty_Program',
            'Blogs',
            'Contact',
        ];

        foreach ($title_section as $key => $title) {
            $dataTrans = []; // Initialize the $dataTrans variable inside the loop

            foreach (config('translatable.locales') as $locale) {
                $dataTrans[$locale]['title'] = Str::replace('_', ' ', $title);
                $dataTrans[$locale]['slug'] = Str::slug($title);
            }
            Menue::create([
                'parent_id' => null,
                // 'level' => $key,
                'type' => 'static',
                'sort' => $key,
                'url' => '#' . strtolower($title),
            ] + $dataTrans);
        }
    }
}

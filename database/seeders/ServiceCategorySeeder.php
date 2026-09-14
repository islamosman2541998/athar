<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serviceCategories = [
            [
                'image' => 'example1.jpg',
                'sort' => 1,
                'feature' => 1,
                'status' => 1,
//                'page_id' => 1,
//                'gallery_id' => 1,
                'service_unique_name' => "events",
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'image' => 'example2.jpg',
                'sort' => 2,
                'feature' => 1,
                'status' => 1,
//                'page_id' => 2,
//                'gallery_id' => 2,
                'service_unique_name' => "landscape",
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'image' => 'example3.jpg',
                'sort' => 3,
                'feature' => 1,
                'status' => 1,
//                'page_id' => 2,
//                'gallery_id' => 3,
                'service_unique_name' => "repair",
                'created_by' => 1,
                'updated_by' => 1,
            ],

        ];

        foreach ($serviceCategories as $category) {
            // Insert the service category
            $categoryId = DB::table('service_categories')->insertGetId($category);

            // Sample translations
            $translations = [
                [
                    'service_cat_id' => $categoryId,
                    'locale' => 'en',
                    'title' => 'Service Category ' . $categoryId,
                    'description' => 'Description for Service Category ' . $categoryId,
                    'slug' => 'service-category-' . $categoryId,
                    'meta_title' => 'Meta Title ' . $categoryId,
//                    'meta_description' => 'Meta Description for ' . $categoryId,
                    'meta_key' => 'Meta Key ' . $categoryId,
                ],
                [
                    'service_cat_id' => $categoryId,
                    'locale' => 'ar',
                    'title' => 'Categoría de Servicio ' . $categoryId,
                    'description' => 'Descripción para la Categoría de Servicio ' . $categoryId,
                    'slug' => 'categoria-de-servicio-' . $categoryId,
                    'meta_title' => 'Título Meta ' . $categoryId,
//                    'meta_description' => 'Descripción Meta para ' . $categoryId,
                    'meta_key' => 'Clave Meta ' . $categoryId,
                ],
                // Add more locales as needed
            ];

            // Insert the translations
            DB::table('service_category_translations')->insert($translations);
        }
    }
}

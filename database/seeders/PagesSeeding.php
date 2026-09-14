<?php

namespace Database\Seeders;

use App\Models\Pages;
use Illuminate\Database\Seeder;
use Database\Factories\PagesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PagesSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $req = [
            $about = [
                'en' => [ 
                    'title' => 'About',
                    'slug' => 'about'
                ],
                'ar' => [   
                    'title' =>'نبذه عنا',
                    'slug' => 'نبذه-عنا'
                ],
            ],
        
            $terms = [
                'en' => [ 
                    'title' => 'Terms of service',
                    'slug' => 'terms-of-service'
                ],
                'ar' => [
                    'title' =>'شروط الخدمة',
                    'slug'  =>'شروط-الخدمة',
                ],
            ],
            $policy = [
                'en' => [ 
                    'title' => 'Privacy policy',
                    'slug'  => 'privacy-policy'
                ],
                'ar' => [
                    'title' =>'سياسة الخصوصية',
                    'slug'  =>'سياسة-الخصوصية',
                ],
            ],
        ];
        if(Pages::query()->get()->count() == 0){
            foreach($req as $rq){
                Pages::create($rq);
            }
        }
       

    }
}

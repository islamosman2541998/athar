<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainPage;
use App\Models\MainPageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainPageController extends Controller
{
    public $ProductCategorys;

    public $productPath;


    public function __construct()
    {

        $this->productPath = '/attachments/main_page/';
    }

//


    public function create()
    {
//        $occasions = Occasion::active()->with('trans' , function ($q){
//            $q->where('locale' , app()->getLocale());
//        })->latest()->get();
        return view('admin/dashboard/main_page/create');
    }


    public function index(Request $request)
    {

//        $query = ProductCategory::query()->with(['trans' => function ($q) {
//            $q->where('locale', app()->getLocale());
//        }
//        ])->orderBy('id', 'DESC');

        $query = MainPage::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }
        ])->orderBy('id', 'DESC');


        $item = $query->first();


        return view('admin/dashboard/main_page/index')->with(['item' => $item]);
    }


    public function store(Request $request)
    {

        $logo = $this->storeImage2($request, $this->productPath, $request->logo, 'logo');
        $firstImg = $this->storeImage2($request, $this->productPath, $request->first_image, 'first_image');
        $secondImg = $this->storeImage2($request, $this->productPath, $request->second_image, 'second_image');
        $our_mission_image = $this->storeImage2($request, $this->productPath, $request->our_mission_image, 'our_mission_image');


        $ProductCategory = MainPage::create(
            [
                'logo' => $logo, //
                'first_image' => $firstImg,
                'second_image' => $secondImg,
                'our_mission_image' => $our_mission_image,
                'phone' => $request->phone ?? '',
                'email' => $request->email ?? '',
                'location' => $request->location ?? '',
            ]
        )->refresh();


        MainPageTranslation::create([

            'locale' => 'ar',
            'main_page_id' => $ProductCategory->id,

            'company_name' => $request->ar['company_name'], //
            'main_title' => $request->ar['main_title'], //
            'main_desc' => $request->ar['main_desc'], //
            'services_title' => $request->ar['services_title'],
            'our_mission_desc' => $request->ar['our_mission_desc'],
            'happiness_title' => $request->ar['happiness_title'],
            'organic_title' => $request->ar['organic_title'],
            'freshness_title' => $request->ar['freshness_title'],
            'delivery' => $request->ar['delivery'],
            'main_last_title' => $request->ar['main_last_title'],
            'main_last_desc' => $request->ar['main_last_desc'],
            'address' => $request->ar['address'],

        ]);


        MainPageTranslation::create([
            'main_page_id' => $ProductCategory->id,

            'locale' => 'en',
            'company_name' => $request->en['company_name'], //
            'main_title' => $request->en['main_title'], //
            'main_desc' => $request->en['main_desc'], //
            'services_title' => $request->en['services_title'],
            'our_mission_desc' => $request->en['our_mission_desc'],
            'happiness_title' => $request->en['happiness_title'],
            'organic_title' => $request->en['organic_title'],
            'freshness_title' => $request->en['freshness_title'],
            'delivery' => $request->en['delivery'],
            'main_last_title' => $request->en['main_last_title'],
            'main_last_desc' => $request->en['main_last_desc'],
            'address' => $request->en['address'],
        ]);


        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect((route('admin.product_category.index')));

    }


    public function edit($id)
    {
        $main = MainPage::find($id);

        return view('admin/dashboard/main_page/edit', compact('main'));
    }


    public function show($id)
    {
        $main = MainPage::find($id);
        return view('admin/dashboard/main_page/show', compact('main'));
    }


    public function update(MainPage $mainPage, Request $request)
    {


        $mainPage->update([


            'phone' => $request->phone ?? '',
            'email' => $request->email ?? '',
            'location' => $request->location ?? '',
//            'status' => $request->status ? 1 : '',
            'updated_by' => auth()->id(),

        ]);


        if ($request->hasFile('logo')) {
            $this->deleteImage($mainPage, 'logo');
            $logo = $this->storeImage2($request, $this->productPath . '/logo/', $request->logo, 'logo' , 'logo');
            $mainPage->logo = $logo;
        }

        if ($request->hasFile('first_image')) {
            $this->deleteImage($mainPage, 'first_image');
            $firstImg = $this->storeImage2($request, $this->productPath. '/first_image/', $request->first_image, 'first_image' , 'first');
            $mainPage->first_image = $firstImg;
        }

        if ($request->hasFile('second_image')) {
            $this->deleteImage($mainPage, 'second_image');
            $secondImg = $this->storeImage2($request, $this->productPath. '/second_image/', $request->second_image, 'second_image' , 'second');
            $mainPage->second_image = $secondImg;
        }

        if ($request->hasFile('our_mission_image')) {
            $this->deleteImage($mainPage, 'our_mission_image');
            $our_mission_image = $this->storeImage2($request, $this->productPath. '/our_mission_image/', $request->our_mission_image, 'our_mission_image' , 'mission');
            $mainPage->our_mission_image = $our_mission_image;
        }

        $mainPage->save();

//        if ($request->image) {
//            $img = $this->storeImage2($request, $this->productPath, $request->image, 'image');
//            $mainPage->image = $img;
//        }

        if ($mainPage->trans() && $mainPage->trans()->count()) {
            $mainPage->trans()->delete();
        }


        $transs = [new   MainPageTranslation([
            'main_page_id' => $mainPage->id,
            'locale' => 'ar',

            'company_name' => $request->en['company_name'], //
            'main_title' => $request->en['main_title'], //
            'main_desc' => $request->en['main_desc'], //
            'services_title' => $request->en['services_title'],
            'our_mission_desc' => $request->en['our_mission_desc'],
            'happiness_title' => $request->en['happiness_title'],
            'organic_title' => $request->en['organic_title'],
            'freshness_title' => $request->en['freshness_title'],
            'delivery' => $request->en['delivery'],
            'main_last_title' => $request->en['main_last_title'],
            'main_last_desc' => $request->en['main_last_desc'],
            'address' => $request->en['address'],

        ]),
            new  MainPageTranslation([
//                    'product_category_id' => $mainPage->id,
//                    'locale' => 'en',
//                    'title' => $request->en['title'] ?? '',
//                    'slug' => $request->en['slug'] ?? '',
//                    'description' => $request->en['description'] ?? '',
//                    'meta_title' => $request->en['meta_title'] ?? '',
//                    'meta_desc' => $request->en['meta_desc'] ?? '',
//                    'meta_key' => $request->en['meta_key'] ?? '',
                    'main_page_id' => $mainPage->id,

                    'locale' => 'en',
                    'company_name' => $request->en['company_name'], //
                    'main_title' => $request->en['main_title'], //
                    'main_desc' => $request->en['main_desc'], //
                    'services_title' => $request->en['services_title'],
                    'our_mission_desc' => $request->en['our_mission_desc'],
                    'happiness_title' => $request->en['happiness_title'],
                    'organic_title' => $request->en['organic_title'],
                    'freshness_title' => $request->en['freshness_title'],
                    'delivery' => $request->en['delivery'],
                    'main_last_title' => $request->en['main_last_title'],
                    'main_last_desc' => $request->en['main_last_desc'],
                    'address' => $request->en['address'],

                ]
            )];

        $mainPage->trans()->saveMany($transs);


        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect((route('admin.main_page.index')));

    }


    public function destroy(ProductCategory $ProductCategory)
    {

        $this->deleteImage($ProductCategory, 'image');
        $ProductCategory->trans()->delete();
        $ProductCategory->delete();

        if ($ProductCategory->galleryGroup && $ProductCategory->galleryGroup->images && $ProductCategory->galleryGroup->images()->count()) {
            foreach ($ProductCategory->galleryGroup->images as $img) {
                $this->deleteImageOfGallery($img->path("product_category"), $img, 'image');
                $img->delete();
            }
        }
        session()->flash('danger', trans('message.admin.deleted_sucessfully'));
        return redirect((route('admin.product_category.index')));

    }


    public function updateFeature($id)
    {
        $product = ProductCategory::find($id);
        if ($product->feature < 1) {
            $product->feature = 1;
        } else {
            $product->feature = 0;
        }
        $product->save();
        session()->flash('success', trans('message.admin.featured_changed_sucessfully'));
        return redirect()->back();
    }


    public function updateStatus($id)
    {
        $product = MainPage::find($id);
        if ($product->status < 1) {
            $product->status = 1;
        } else {
            $product->status = 0;
        }
        $product->save();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();


    }


    public function destroyImage($id)
    {

        $img = Gallery::find($id);
        $this->deleteImageOfGallery($img->path("product_category"), $img, 'image');
        $img->delete();
        session()->flash('success', trans('message.admin.message.admin.deleted_sucessfully'));
        return redirect()->back();


    }


    /***********################################################***************/

    public function actions(Request $request)
    {

        if ($request['publish'] == 1) {
            $products = ProductCategory::findMany($request['record']);
            foreach ($products as $product) {
                $product->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $products = ProductCategory::findMany($request['record']);
            foreach ($products as $product) {
                $product->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $products = ProductCategory::findMany($request['record']);
            foreach ($products as $product) {
                if ($product->path() . $product->image) {
                    $img = $this->deleteImage($product, 'image');

                    @unlink($product->path() . $product->image);
                    $product->delete();
                }
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


}

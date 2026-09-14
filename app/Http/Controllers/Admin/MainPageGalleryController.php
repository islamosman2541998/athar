<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Gallery;
use App\Models\GalleryGroup;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTranslation;
use App\Traits\FileHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainPageGalleryController extends Controller
{
    use FileHandler;
    public $products;
    public $productPath;
    public $galleryPath;


    public function __construct()
    {

        $this->galleryPath = "/attachments/gallery/main_page/";


    }


    public function index(Request $request)
    {
        $items= Gallery::whereHas('gallery_group', function($q) {
            $q->where('type', 4);
        })->with('gallery_group')->get();

         return view('admin/dashboard/main_page/gallery/index')->with(['items' => $items]);
    }



    /**************test ************/

    /**************end test **********/


    public function show(GalleryGroup $galleryGroup)
    {
        $galleryGroup->load(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }
        ]);
        return view('admin/dashboard/main_page/gallery/show')->with(['galleryGroup' => $galleryGroup]);
    }


    public function edit(  $id)
    {
        $galleryGroup =GalleryGroup::find($id);
        return view('admin/dashboard/main_page/gallery/edit')->with(['galleryGroup' => $galleryGroup ]);
    }


    public function update($id , Request $request)
    {
        $galleryGroup = GalleryGroup::find($id);


        if($galleryGroup->galleryGroup &&  $request->group_title) {
//            $galleryGroup->update(
//                [
//                    'title' => $request->group_title,
//                    'title_en' => $request->group_title_en,
//                ]
//            );
        }

        if ($request->gallery_image) {


            if ($galleryGroup && $galleryGroup->images) {
                $group =$galleryGroup;

            } else {
                $group = GalleryGroup::create([
                    'type' => 4,
                    'status' => 1,
                    'foreign_key' => null,
                    'created_by' => auth()->id(),
                ])->refresh();
            }


            $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');

            $imgArr = [];
            foreach ($request->gallery_image as $keyImg => $valImg) {
//               $imgItem =  $this->storeImage2($request , "/attachments/gallery/products/" , $request->gallery_image[$keyImg] , 'gallery_image');
                $imgArr[] = new Gallery([
                    'image' => $all_images_returned_arr[$keyImg] ?? '',
                    'sort' => $request->gallery_sort[$keyImg] ?? '',
                    'gallery_group_id' => $group->id,
                    'feature' => isset($request->gallery_feature[$keyImg]) ? (int)$request->gallery_feature[$keyImg] : 0,
                    'status' => 1,
                    'created_by' => auth()->id(),
                ]);
            }


            $group->images()->saveMany($imgArr);

        }



        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function create()
    {
        $cats = ProductCategory::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }
        ])->active()->latest()->get();
        $occasions = Occasion::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->where('status', 1)->where('type' , 0)->latest()->get();
        return view('admin/dashboard/main_page/gallery/create', compact('occasions', 'cats'));
    }


    public function store(Request $request)
    {


         if ($request->gallery_image) {
            $group = GalleryGroup::create([
                'type' => 4,
                'status' => 1,
                'foreign_key' => null,
                'created_by' => auth()->id(),
            ])->refresh();

            if ($request->gallery_image) {
                //here
                $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');

                $imgArr = [];
                foreach ($request->gallery_image as $keyImg => $valImg) {
//               $imgItem =  $this->storeImage2($request , "/attachments/gallery/products/" , $request->gallery_image[$keyImg] , 'gallery_image');
                    $imgArr[] = new Gallery([
                        'image' => $all_images_returned_arr[$keyImg] ?? '',
                        'sort' => $request->gallery_sort[$keyImg] ?? '',
                        'gallery_group_id' => $group->id,
                        'feature' => isset($request->gallery_feature[$keyImg]) ? (int)$request->gallery_feature[$keyImg] : 0,
                        'status' => 1,
                        'created_by' => auth()->id(),
                    ]);
                }
            }


            $group->images()->saveMany($imgArr);

        }


         session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect()->back();


    }


    public function destroyImage($id)
    {

        $img = Gallery::find($id);

        $this->deleteImageOfGallery($img->path("main_page"), $img, 'y freing');

        $img->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();


    }



    public function actions(Request $request)
    {

//        if ($request['publish'] == 1) {
//            $products = Product::findMany($request['record']);
//            foreach ($products as $product) {
//                $product->update(['status' => 1]);
//            }
//            session()->flash('success', trans('pages.status_changed_sucessfully'));
//        }
//        if ($request['unpublish'] == 1) {
//            $products = Product::findMany($request['record']);
//            foreach ($products as $product) {
//                $product->update(['status' => 0]);
//            }
//            session()->flash('success', trans('pages.status_changed_sucessfully'));
//        }
        if ($request['delete_all'] == 1) {
             $products = Gallery::findMany($request['record']);
            foreach ($products as $product) {

                if ($product->path('main_page') . $product->image) {
                    $img = $this->deleteImageOfGallery($product->path('main_page') . $product->image , $product, 'image' );


                    @unlink($product->path('main_page') . $product->image);
                    $product->delete();
                }
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


}

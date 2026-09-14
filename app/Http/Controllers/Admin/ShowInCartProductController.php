<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Occasion;
use App\Models\Settings;
use App\Traits\FileHandler;
use App\Models\GalleryGroup;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization; 

class ShowInCartProductController extends Controller
{
    use FileHandler;
    public $products;
    public $productPath;
    public $galleryPath;


    public function __construct()
    {
        $this->products = Product::with(
            ['trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
            ]
        )->with('occasions.trans')->latest()->paginate(20);

        $this->productPath = '/attachments/products/';
        $this->galleryPath = "/attachments/gallery/products/";


    }


    public function index(Request $request)
    {
        $occasions = Occasion::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }
        ])->where('type', 0)->active()->latest()->get();
//        $cats = ProductCategory::with(['trans' => function ($q) {
//            $q->where('locale', app()->getLocale());
//        }
//        ])->active()->latest()->get();

        $query = Product::query()->with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }
        ])->with('occasions.trans')->showincart()->orderBy('id', 'DESC')->showincart();

        if ($request->status != '') {
            if ($request->status == 1) $query->where('status', $request->status);
            else {
                $query->where('status', '!=', 1);
            }
        }
        if ($request->title != '') {
            $query = $query->whereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        if ($request->description != '') {
            $query = $query->whereTranslationLike('description', '%' . request()->input('description') . '%');
        }

        /*************************search of price******************/
        if ($request->from_price != '' && $request->to_price == '') {
            $query = $query->where('price', '>=', $request->from_price);
        }
        if ($request->to_price != '' && $request->from_price == '') {
            $query = $query->where('price', '<=', $request->to_price);
        }
        if ($request->to_price != '' && $request->from_price != '') {
            $query = $query->where('price', '<=', $request->to_price)->where('price', '>=', $request->from_price);
        }
        /*************************search of price******************/


        /*************************search of date******************/
        if ($request->from_date && $request->to_date) {
            $from = date($request->from_date);
            $to = date($request->to_date);
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }
        if ($request->from_date != '' && $request->to_date == '') {
            $from = date($request->from_date);
            $query->whereDate('created_at', '>', Carbon::parse($from));
        }
        if ($request->to_date != '' && $request->from_date == '') {
            $to = date($request->to_date);
            $query->whereDate('created_at', '<', Carbon::parse($to));
        }
        /*************************search of date******************/


        if ($request->occasions != '') {
            $query = $query->whereHas('occasions', function ($q) {
                $q->whereTranslationLike('title', request()->input('occasions'));
            });
        }

//        if ($request->cat_id != '') {
//            $query = $query->whereHas('productCat', function ($q) {
//                $q->whereTranslationLike('title', request()->input('cat_id'));
//            });
//
//        }

        $items = $query->paginate($this->pagination_count);


        return view('admin/dashboard/products/products_show_in_cart/index')->with(['items' => $items, 'occasions' => $occasions]);
    }



    /**************test ************/

    /**************end test **********/


    public function show($id)
    {
        $product = Product::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->showincart()->find($id);

        return view('admin/dashboard/products/products_show_in_cart/show')->with(['product' => $product]);
    }


    public function create()
    {
        $cats = ProductCategory::showincart()->active()->get();

        $occasions = Occasion::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->where('status', 1)->where('type', 0)->latest()->get();
        return view('admin/dashboard/products/products_show_in_cart/create', compact('occasions', 'cats'));
    }


    public function store(ProductRequest $request)
    {

        $img = $this->storeImage2($request, $this->productPath, $request->image, 'image');
        $product = Product::create($request->all());
        $product->image = $img;
        $product->created_by = auth()->id();
        $product->show_in_cart = 1;
        $product->save();
        if ($request->gallery_image) {
            $group = GalleryGroup::create([
                'type' => 0,
                'status' => 1,
                'foreign_key' => $product->id,
                'created_by' => auth()->id(),
            ])->refresh();
            $group->update($request->gallery);

            if ($request->gallery_image) {
                $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');
                $imgArr = [];
                foreach ($request->gallery_image as $keyImg => $valImg) {
//               $imgItem =  $this->storeImage2($request , "/attachments/gallery/products/" , $request->gallery_image[$keyImg] , 'gallery_image');
                    $imgArr[] = new Gallery([
                        'image' => $all_images_returned_arr[$keyImg] ?? '',
                        'sort' => $request->gallery_sort[$keyImg] ?? '',
                        'gallery_group_id' => $group->id,
                        'feature' => isset($request->gallery_feature[$keyImg]) ? (int)$request->gallery_feature[$keyImg] : 0,
                        'title' => $request->gallery_title[$keyImg] ?? '',
                        'title_en' => $request->gallery_title_en[$keyImg] ?? '',
                        'status' => 1,
                        'created_by' => auth()->id(),
                    ]);
                }
            }


            $group->images()->saveMany($imgArr);

        }


        if ($request->occasions) {
            $product->occasions()->attach($request->occasions);
        }
        $cat = ProductCategory::showincart()->active()->value('id');
        $cat ? $product->productCategoriesProducts()->attach($cat) : '';
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect(LaravelLocalization::localizeURL(route('admin.show_in_cart_product_list')));


    }


    public function edit($id)
    {
        $cats = ProductCategory::showincart()->active()->get();

        $occasions = Occasion::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->where('status', 1)->where('type', 0)->latest()->get();

        $product = Product::with('trans')->showincart()->find($id);

        if (!$product) {
            return redirect()->back();
        }
        return view('admin/dashboard/products/products_show_in_cart/edit')->with(['product' => $product, 'occasions' => $occasions, 'cats' => $cats]);
    }


//            $group->images()->saveMany($imgArr);

    public function update($id, ProductRequest $request)
    {
        $product = Product::find($id);
        $product->update($request->getSanitized());

        $img = $this->storeImage2($request, $this->productPath, $request->image, 'image');
        $product->image = $img;
        $product->updated_by = auth()->id();
        $product->show_in_cart = 1;
        $product->save();


        if ($product->galleryGroup) {
            $groupGallery = $product->galleryGroup;
        } else {
            $groupGallery = GalleryGroup::create([
                'type' => 0,
                'status' => 1,
                'foreign_key' => $product->id,
                'created_by' => auth()->id(),
            ])->refresh();
        }
        $groupGallery->update($request->gallery);


        $group = $groupGallery;

        if ($request->gallery_image) {
            $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');

            $imgArr = [];
            foreach ($request->gallery_image as $keyImg => $valImg) {   //"/attachments/gallery/products/"
                $imgArr[] = new Gallery([
                    'image' => $all_images_returned_arr[$keyImg] ?? '',
                    'sort' => $request->gallery_sort[$keyImg] ?? '',
                    'gallery_group_id' => $group->id,
                    'feature' => isset($request->gallery_feature[$keyImg]) ? (int)$request->gallery_feature[$keyImg] : 0,
                    'title' => $request->gallery_title[$keyImg] ?? '',
                    'title_en' => $request->gallery_title_en[$keyImg] ?? '',
                    'status' => 1,
                    'created_by' => auth()->id(),
                ]);
            }
            $group->images()->saveMany($imgArr);
        }

        if ($request->occasions) {
            $product->occasions()->sync($request->occasions);
        }


        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy($id)
    {

        $product = Product::find($id);
        $this->deleteImage($product, 'image');
        $product->update(['updated_by' => auth()->id()]);
        $product->trans()->delete();
        $product->delete();

        session()->flash('danger', trans('message.admin.deleted_sucessfully'));
        return redirect(LaravelLocalization::localizeURL(route('admin.show_in_cart_product_list')));

    }


    public function updateFeature($id)
    {
        $product = Product::find($id);
        if ($product->feature < 1) {
            $product->feature = 1;
        } else {
            $product->feature = 0;
        }
        $product->updated_by = auth()->id();
        $product->save();
        session()->flash('success', trans('message.admin.featured_changed_sucessfully'));
        return redirect()->back();
    }


    public function updateStatus($id)
    {
        $product = Product::find($id);
        if ($product->status < 1) {
            $product->status = 1;
        } else {
            $product->status = 0;
        }
        $product->updated_by = auth()->id();
        $product->save();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();


    }


    public function destroyImage($id)
    {

        $img = Gallery::find($id);
//        $this->deleteImageOfGallery($img->pathInView("products"), $img, 'gallery_image');
        $this->deleteImageOfGallery($img->path("products"), $img, 'image');

        $img->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();


    }


    /***********################################################***************/

    public function actions(Request $request)
    {

        if ($request['publish'] == 1) {
            $products = Product::findMany($request['record']);
            foreach ($products as $product) {
                $product->update(['status' => 1, 'updated_by' => auth()->id()]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $products = Product::findMany($request['record']);
            foreach ($products as $product) {
                $product->update(['status' => 0, 'updated_by' => auth()->id()]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $products = Product::findMany($request['record']);
            foreach ($products as $product) {
                if ($product->path() . $product->image) {
                    $this->deleteImage($product, 'image');
                    @unlink($product->path() . $product->image);
                    $product->update(['updated_by' => auth()->id()]);
                    $product->delete();
                }
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


}
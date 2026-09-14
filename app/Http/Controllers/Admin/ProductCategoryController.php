<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryRequest;
use App\Models\Gallery;
use App\Models\GalleryGroup;
use App\Models\GalleryGroupTranslation;
use App\Models\Occasion;
use App\Models\ProductCategory;
use App\Models\ProductCategoryTranslation;
use Illuminate\Http\Request;
use App\Traits\TranslatableHandler;

class ProductCategoryController extends Controller
{

    use TranslatableHandler;
    public $ProductCategorys;
    public $productPath;
    public $galleryPath;


    public function __construct()
    {
        $this->ProductCategorys = ProductCategory::with(
            [
                'trans' => function ($q) {
                    $q->where('locale', app()->getLocale());
                }
            ]
        )->latest()->paginate($this->pagination_count);


        $this->productPath = '/attachments/product_category/main_images/';
        $this->galleryPath = "/attachments/gallery/product_category/";
    }

    public function create()
    {
        return view('admin/dashboard/product_categories/create');
    }


    public function index(Request $request)
    {

        $query = ProductCategory::query()->orderBy('id', 'DESC');


        if ($request->status != '') {
            if ($request->status == 1) $query->where('status', $request->status);
            else {
                $query->where('status', '!=', 1);
            }
        }
        if ($request->title !== '') {
        $search = '%'.$request->input('title').'%';
        $query->whereHas('trans', function($q) use ($search) {
            $q->where('locale', app()->getLocale())
              ->where('title', 'LIKE', $search);
        });
    }

        if ($request->description != '') {
            $query = $query->whereTranslationLike('description', '%' . request()->input('description') . '%');
        }

        $items = $query->paginate($this->pagination_count);


        return view('admin/dashboard/product_categories/index')->with(['items' => $items]);
    }


    public function store(ProductCategoryRequest $request)
    {

        $data = $request->getSanitized();
        $productCategory = ProductCategory::create($data);
        $this->saveModelTranslation($productCategory, $data);

        if ($request->gallery) {
            $groupGallery = GalleryGroup::create([
                'type' => 1,
                'status' => 1,
                'annual_occasion' => 1,
                'show_in_bottom' => 1,
                'foreign_key' => $productCategory->id,
                'created_by' => auth()->id(),
            ])->refresh();


            $groupGallery->update($request->gallery);
            $group = $productCategory->galleryGroup;
        }

        if ($request->gallery_image && $group) {
            $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');

            $imgArr = [];
            foreach ($request->gallery_image as $keyImg => $valImg) {   //"/attachments/gallery/products/"
                $imgArr[] = new Gallery([
                    'image' => $all_images_returned_arr[$keyImg] ?? '',
                    'sort' => $request->gallery_sort[$keyImg] ?? '',
                    'gallery_group_id' => $group->id,
                    'feature' => isset($request->gallery_feature[$keyImg]) ? (int)$request->gallery_feature[$keyImg] : 0,
                    'status' => 1,
                    'annual_occasion' => 1,
                    'show_in_bottom' => 1,
                    'created_by' => auth()->id(),
                ]);
            }


            $group->images()->saveMany($imgArr);
        }


        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect(route('admin.product_category.index'));
    }



    public function edit($id)
    {
        $category = ProductCategory::with('trans', 'galleryGroup.images')->find($id);

        return view('admin/dashboard/product_categories/edit', compact('category'));
    }







    public function show($id)
    {
        $category = ProductCategory::with('trans', 'galleryGroup.images')->find($id);
        return view('admin/dashboard/product_categories/show', compact('category'));
    }


    public function update(ProductCategory $productCategory, ProductCategoryRequest $request)
    {
        if ($productCategory) {
            $data = $request->getSanitized();

            $productCategory->update($data);

            $this->saveModelTranslation($productCategory, $data);
        }

        if ($productCategory->galleryGroup  && $request->gallery) {
            $productCategory->galleryGroup->update($request->gallery);
        } elseif ($request->gallery) {
            $groupGallery = GalleryGroup::create([
                'type' => 1,
                'status' => 1,
                // 'annual_occasion' => 1,
                'foreign_key' => $productCategory->id,
                'created_by' => auth()->id(),
            ])->refresh();
            $groupGallery->update($request->gallery);
            $group = $groupGallery;
        }


        $group = $productCategory->galleryGroup;

        if ($request->gallery_image && $group) {
            $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');

            $imgArr = [];
            foreach ($request->gallery_image as $keyImg => $valImg) {   //"/attachments/gallery/products/"
                $imgArr[] = new Gallery([
                    'image' => $all_images_returned_arr[$keyImg] ?? '',
                    'sort' => $request->gallery_sort[$keyImg] ?? '',
                    'gallery_group_id' => $group->id,
                    'feature' => isset($request->gallery_feature[$keyImg]) ? (int)$request->gallery_feature[$keyImg] : 0,
                    'status' => 1,
                    'annual_occasion' => 1,
                    'show_in_bottom' => 1,

                    'created_by' => auth()->id(),
                ]);
            }


            $group->images()->saveMany($imgArr);
        }

        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }







    public function destroy(ProductCategory $ProductCategory)
    {
        $m =  $ProductCategory->products;
        if ($m->count() > 0) {
            session()->flash('error', trans('message.admin.you can not delete this item until deleting its products first'));
            return redirect()->back();
        }

        $this->deleteImage($ProductCategory, 'image');
        // $ProductCategory->trans()->delete();
        $ProductCategory->delete();

        if ($ProductCategory->galleryGroup && $ProductCategory->galleryGroup->images && $ProductCategory->galleryGroup->images()->count()) {
            foreach ($ProductCategory->galleryGroup->images as $img) {
                $this->deleteImageOfGallery($img->path("product_category"), $img, 'image');
                $img->delete();
            }
        }
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->route('admin.product_category.index');
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
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.featured_changed_sucessfully'));
        return redirect()->back();
    }


    public function updateStatus($id)
    {
        $product = ProductCategory::find($id);
        if ($product->status < 1) {
            $product->status = 1;
        } else {
            $product->status = 0;
        }
        $product->save();
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();
    }
    public function updateannual_occasion($id)
    {
        $product = ProductCategory::find($id);
        if ($product->annual_occasion < 1) {
            $product->annual_occasion = 1;
        } else {
            $product->annual_occasion = 0;
        }
        $product->save();
        session()->flash('success', trans('message.admin.annual_occasion_changed_sucessfully'));
        return redirect()->back();
    }
    public function updateshow_in_bottom($id)
    {
        $product = ProductCategory::find($id);
        if ($product->show_in_bottom < 1) {
            $product->show_in_bottom = 1;
        } else {
            $product->show_in_bottom = 0;
        }
        $product->save();
        session()->flash('success', trans('message.admin.show_in_bottom_changed_sucessfully'));
        return redirect()->back();
    }



    public function destroyImage($id)
    {
        $img = Gallery::find($id);
        $this->deleteImageOfGallery($img->path("product_category"), $img, 'image');
        $img->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

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
        $this->clearHomeCache();
        return redirect()->back();
    }
}

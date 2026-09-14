<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use App\Models\Occasion;
use App\Traits\FileHandler;
use App\Models\GalleryGroup;
use Illuminate\Http\Request;
use App\Models\OccasionTranslation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OccasionRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class OccasionsController extends Controller
{
    use FileHandler;

    public $occasions;
    public $occasionPath;
    public $galleryPath;


    public function __construct()
    {
        $this->occasions = Occasion::with(
            [
                'trans' => function ($q) {
                    $q->where('locale', app()->getLocale());
                }
            ]
        )->latest()->paginate(20);

        $this->occasionPath = '/attachments/occasions/main_images/';
        $this->galleryPath = "/attachments/gallery/occasions/";
    }

    public function create()
    {
        return view('admin/dashboard/occassions/create');
    }


    public function index(Request $request)
    {
        $query = Occasion::query()->with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->orderBy('id', 'DESC');

        if ($request->status != '') {
            if ($request->status == 1) $query->where('status', 1);
            else {
                $query->where('status', 0);
            }
        }

        if ($request->type != '') {
            if ($request->type == 1) $query->where('type', 1);
            else {
                $query->where('type', 0);
            }
        }

        if ($request->title !== '') {
            $search = '%' . $request->input('title') . '%';
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                    ->where('title', 'LIKE', $search);
            });
        }

        $items = $query->paginate($this->pagination_count);
        $arr = [__('admin.products'), __('admin.service_category')];
        return view('admin/dashboard/occassions/index')->with(['items' => $items, 'arr' => $arr]);
    }


    public function occasions_services(Request $request)
    {
        $query = Occasion::query()->with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->where('type', 1)->orderBy('id', 'DESC');


        if ($request->status != '') {
            if ($request->status == 1) $query->where('status', 1);
            else {
                $query->where('status', 0);
            }
        }

        if ($request->type != '') {
            if ($request->type == 1) $query->where('type', 1);
            else {
                $query->where('type', 0);
            }
        }

        if ($request->title !== '') {
            $search = '%' . $request->input('title') . '%';
            $query->whereHas('transNow', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                    ->where('title', 'LIKE', $search);
            });
        }

        $items = $query->paginate($this->pagination_count);
        $arr = [__('admin.products'), __('admin.service_category')];

        return view('admin/dashboard/occassions/index_services')->with(['items' => $items, 'arr' => $arr]);
    }


    public function occasions_products(Request $request)
    {
        $query = Occasion::query()->with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->where('type', 0)->orderBy('id', 'DESC');


        if ($request->status != '') {
            if ($request->status == 1) $query->where('status', 1);
            else {
                $query->where('status', 0);
            }
        }

        if ($request->type != '') {
            if ($request->type == 1) $query->where('type', 1);
            else {
                $query->where('type', 0);
            }
        }

        if ($request->title !== '') {
            $search = '%' . $request->input('title') . '%';
            $query->whereHas('transNow', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                    ->where('title', 'LIKE', $search);
            });
        }

        $items = $query->paginate($this->pagination_count);
        $arr = [__('admin.products'), __('admin.service_category')];
        return view('admin/dashboard/occassions/index_products')->with(['items' => $items, 'arr' => $arr]);
    }


    public function store(OccasionRequest $request)
    {
        $occasion = Occasion::create([
            'name' => $request->name,
            'type' => $request->type ?? 0,
            'status' => $request->status ?? 0,
            'image' => $request->image ?? null,
            'featured' => $request->featured ?? 0,
            'sort' => $request->sort,
            'created_by' => auth()->id(),
        ]);

        if ($request->image) {
            $img = $this->storeImage2($request, $this->occasionPath, $request->image, 'image');
            $occasion->image = $img;
            $occasion->save();
        }

        $occasion->trans()->create([
            'product_id' => $occasion->id,
            'locale' => 'ar',
            'title' => $request->ar['title'],
            'description' => $request->ar['description'],
        ]);

        $occasion->trans()->create([
            'product_id' => $occasion->id,
            'locale' => 'en',
            'title' => $request->en['title'] ?? '',
            'description' => $request->en['description'] ?? '',
        ]);

        if ($request->gallery_image) {

            $data = [
                'type' => 3,
                'status' => 1,
                'foreign_key' => $occasion->id,
                'created_by' => auth()->id(),
                'ar' => ['title' => $request->gallery['ar']['title']],
                'en' => ['title' => $request->gallery['en']['title']],
            ];
            $group = GalleryGroup::create($data);



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

        $arrNames = [0 => 'admin.occasions_products_index.index', 1 => 'admin.occasions_services_index.index'];
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect(LaravelLocalization::localizeURL(route($arrNames[$request->type ?? 0])));
    }


    public function destroy(Occasion $occasion) //here
    {
        if ($occasion->galleryGroup && isset($occasion->galleryGroup[0]->images) && $occasion->galleryGroup[0]->images->count()) {
            $groupIds = $occasion->galleryGroup->pluck('id');
            Gallery::whereIn('gallery_group_id', $groupIds)->delete();
            GalleryGroup::whereIn('id', $groupIds)->delete();
            $occasion->trans()->delete();
        }
        $occasion->delete();
        session()->flash('danger', trans('message.admin.deleted_sucessfully'));
        return redirect(LaravelLocalization::localizeURL(route('admin.occasions.index')));
    }


    public function edit($id)
    {
        $occasion = Occasion::with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->findOrFail($id);
        return view('admin/dashboard/occassions/edit', compact('occasion'));
    }


    public function update(Occasion $occasion, OccasionRequest $request)
    {
        $occasion->load('trans');
        $occasion->trans()->delete();
        $occasion->update([
            'name' => $request->name,
            'status' => $request->status ?? 0,
            'image' => $request->image ?? null,
            'featured' => $request->featured ?? 0,
            'sort' => $request->sort,
            'updated_by' => auth()->id(),
        ]);

        if ($request->image) {
            $img = $this->storeImage2($request, $this->occasionPath, $request->image, 'image');
            $occasion->image = $img;
            $occasion->save();
        }

        $occasion->trans()->create([
            'product_id' => $occasion->id,
            'locale' => 'ar',
            'title' => $request->ar['title'],
            'description' => $request->ar['description'],
        ]);

        $occasion->trans()->create([
            'product_id' => $occasion->id,
            'locale' => 'en',
            'title' => $request->en['title'] ?? '',
            'description' => $request->en['description'] ?? '',
        ]);

        if ($request->gallery_image) {
            if ($occasion->galleryGroup && $occasion->galleryGroup->count() && isset($occasion->galleryGroup->images)) {
                $group = $occasion->galleryGroup;
            } else {

                $data = [
                    'type' => 3,
                    'status' => 1,
                    'foreign_key' => $occasion->id,
                    'created_by' => auth()->id(),
                    'ar' => ['title' => $request->gallery['ar']['title']],
                    'en' => ['title' => $request->gallery['en']['title']],
                ];
                $group = GalleryGroup::create($data);
            }


            $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');

            $imgArr = [];
            foreach ($request->gallery_image as $keyImg => $valImg) {
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
        session()->flash('success', trans('message.admin.updated_successfully'));
        return redirect()->back();
    }


    public function show($id)
    {
        $occasion = Occasion::findOrFail($id);
        return view('admin/dashboard/occassions/show', compact('occasion'));
    }


    public function updateFeature($id)
    {
        $product = Occasion::find($id);
        if ($product->featured < 1) {
            $product->featured = 1;
        } else {
            $product->featured = 0;
        }
        $product->save();
        session()->flash('success', trans('message.admin.featured_changed_sucessfully'));
        return redirect()->back();
    }


    public function updateStatus($id)
    {
        $product = Occasion::find($id);
        if ($product->status == 0) {
            $product->status = 1;
        } else {
            $product->status = 0;
        }
        $product->save();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();
    }


    /***********################################################***************/

    public function actions(Request $request)
    {

        if ($request['publish'] == 1) {
            $products = Occasion::findMany($request['record']);
            foreach ($products as $product) {
                $product->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $products = Occasion::findMany($request['record']);
            foreach ($products as $product) {
                $product->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $products = Occasion::findMany($request['record']);
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

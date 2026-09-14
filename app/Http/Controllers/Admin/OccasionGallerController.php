<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OccasionRequest;
use App\Models\Gallery;
use App\Models\GalleryGroup;
use App\Models\GalleryGroupTranslation;
use App\Models\Occasion;
use App\Traits\FileHandler;
use Illuminate\Http\Request;

class OccasionGallerController extends Controller
{
    use FileHandler;

    public $occasions;
    public $occasionPath;
    public $galleryPath;


    public function __construct()
    {
        $this->occasions = Occasion::with(
            ['trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
            ]
        )->latest()->paginate(20);

        $this->occasionPath = '/attachments/occasions/main_images/';
        $this->galleryPath = "/attachments/gallery/occasions/";

    }

    public function create($id)
    {

        return view('admin/dashboard/occassions/occasion_gallery/create', ['occ_id' => $id]);
    }

    public function index(Request $request, $occ_id)
    {
        $occ = Occasion::with('galleryGroup.mainImage')->find($occ_id);

        $items = $occ && $occ->galleryGroup && $occ->galleryGroup->count() ? $occ->galleryGroup()->latest()->get() : null;
        return view('admin/dashboard/occassions/occasion_gallery/index')->with(['items' => $items, 'id' => $occ_id, 'occ_type' => $occ->type]);

    }


    public function store(Request $request, $occ_id)
    {
        if ($request->gallery_image) {
            $group = GalleryGroup::create([
                'type' => 3,
                'status' => 1,
                'foreign_key' => $occ_id,
                'created_by' => auth()->id(),
            ])->refresh();


            GalleryGroupTranslation::create([
                'gallery_group_id' => $group->id,
                'locale' => 'ar',
                'title' => $request->ar['title'],
//                'description' => $request->ar['description'],
            ]);


            GalleryGroupTranslation::create([
                'gallery_group_id' => $group->id,
                'locale' => 'en',
                'title' => $request->en['title'] ?? '',
//                'description' => $request->en['description'] ?? '',
            ]);


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
//                        'title' => $request->gallery_title[$keyImg] ?? '',
//                        'title_en' => $request->gallery_title_en[$keyImg] ?? '',

                    'status' => 1,
                    'created_by' => auth()->id(),
                ]);
            }


            $group->images()->saveMany($imgArr);

        }


        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect((route('admin.occasion_gallery.index', ['occ_id' => $occ_id])));
    }


    public function destroy($occ_id, $id)
    {

        $group = GalleryGroup::where('foreign_key', $occ_id)->where('type', 3)->find($id);

        $group->translations()->delete();
        if ($group->images && $group->images->count()) {
            $group->images()->delete();

        }

        $group->delete();
        session()->flash('danger', trans('message.admin.deleted_sucessfully'));
        return redirect((route('admin.occasion_gallery.index', ['occ_id' => $occ_id])));
    }



    public function edit($occ_id, $id)
    {
        $group_gallery = GalleryGroup::with('translation')->find($id);
        if (!$group_gallery) {
            session()->flash('error', trans('message.admin.not_found'));
            return redirect('admin/occasion_group_gallerys/' . $occ_id);
        }

        return view('admin/dashboard/occassions/occasion_gallery/edit', ['group_gallery' => $group_gallery, 'occ_id' => $occ_id]);
    }

    public function update($occ_id, $id, Request $request)
    {


        $gallery_group = GalleryGroup::find($id);
//        $gallery_group->load('trans');
        if ($gallery_group->translations() && $gallery_group->translations()->count()) {
            $gallery_group->translations()->delete();
        }

        $gallery_group->translations()->create([
            'gallery_group_id' => $gallery_group->id,
            'locale' => 'ar',
            'title' => $request->ar['title'],
//                'description' => $request->ar['description'],
        ]);


        $gallery_group->translations()->create([
            'gallery_group_id' => $gallery_group->id,
            'locale' => 'en',
            'title' => $request->en['title'] ?? '',
//                'description' => $request->en['description'] ?? '',
        ]);


        $gallery_group->update([
//                'name' => $request->name,
            'type' => 3,
            'status' => 1,
            'featured' => $request->featured ?? 0,
            'sort' => $request->sort,
            'updated_by' => auth()->id(),
        ]);

//        if ($request->image) {
//            $img = $this->storeImage2($request, $this->occasionPath, $request->image, 'image');
//            $occasion->image = $img;
//            $occasion->save();
//        }


        if ($request->gallery_image) {
            $group = $gallery_group;


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

        session()->flash('success', trans('message.admin.updated_successfully'));
        return redirect(app()->getLocale() . '/admin/occasions/'.$occ_id.'/edit?occ_type=services');

    }

    public function show($occ_id, $id)
    {
        $group_gallery = GalleryGroup::find($id);
        if (!$group_gallery) {
            session()->flash('error', trans('message.admin.not_found'));
            return redirect('admin/occasion_group_gallerys/' . $occ_id);
        }
        return view('admin/dashboard/occassions/occasion_gallery/show', ['group_gallery' => $group_gallery, 'occ_id' => $occ_id]);
    }





    public function updateStatus($id)
    {
        $group = GalleryGroup::find($id);
        if (!$group) {
            session()->flash('error', trans('message.admin.not_found'));
            return redirect()->back();
        }
        if ($group->status < 1) {
            $group->status = 1;
        } else {
            $group->status = 0;
        }
        $group->save();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();


    }


    /***********################################################***************/

    public function actions($occ_id, Request $request)
    {

        if ($request['publish'] == 1) {
            $products = GalleryGroup::findMany($request['record']);
            foreach ($products as $product) {
                $product->update(['status' => 1]);
            }

            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $products = GalleryGroup::findMany($request['record']);
            foreach ($products as $product) {
                $product->update(['status' => 0]);
            }

            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $productsIds = GalleryGroup::findMany($request['record']);


            foreach ($productsIds as $productItem) {
                foreach ($productItem->images as $product) {
                    if ($product->path('occasions') . $product->image) {
                        $img = $this->deleteImageOfGallery($product->path('occasions'), $product, 'image');

//                        @unlink($product->path('occasions') . $product->image);
                        $product->delete();
                    }
                }
                $productItem->delete();
            }

            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


    public function delete_album($id)
    {
        $group = GalleryGroup::with('images')->find($id);
        if(!$group){
            session()->flash('error', trans('pages.not_found'));
            return redirect()->back();
        }
        $imagesIds = $group->images()->pluck('id');
        Gallery::whereIn('id', $imagesIds)->delete();
        $group->delete();

        session()->flash('success', trans('pages.delete_all_sucessfully'));
        return redirect()->back();


    }
}

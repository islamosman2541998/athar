<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Gallery;
use App\Models\Occasion;
use App\Traits\FileHandler;
use App\Models\GalleryGroup;
use Illuminate\Http\Request;
use App\Models\EventFollowing;
use App\Models\ServiceCategory;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\EventFollowingTranslation;
use App\Models\ServiceCategoryTranslation;
use App\Http\Requests\Admin\ServiceCategoryRequest;
use App\Http\Requests\EventCategoryRequest; // Assuming you created one


class ServiceCategoryEventsController extends Controller
{
    use FileHandler;
    public $serviceCategory_categoryPath;
    public $galleryPath;


    public function __construct()
    {
        $this->product_categoryPath = '/attachments/service_category/main_images/';
        $this->galleryPath = "/attachments/gallery/service_category/";
    }


    public function index(Request $request)
    {

        $service_category = ServiceCategory::with('galleryGroup.images' , 'occasions','getFollowings')->where('service_unique_name' , 'events')->first();

        $occasions = Occasion::latest()->where('type', 1)->active()->get();
        if(!$service_category){
            return redirect()->route('admin.events.create');
            
        }

        return view('admin/dashboard/service_category/events/edit', compact('service_category', 'occasions'));
    }


    public function create()
    {
        $occasions = Occasion::where('type', 1)->latest()->active()->get();
        return view('admin/dashboard/service_category/events/create', compact('occasions'));
    }




    public function store(ServiceCategoryRequest $request)
{
   $serviceCategory = ServiceCategory::create($request->getSanitized());
        $serviceCategory->service_unique_name = 'events';
        $serviceCategory->save();

 

     if ($request->filled('new_following')) {
            foreach ($request->new_following as $newFollowing) {
                $following = new EventFollowing();
                $following->event_id = $serviceCategory->id;

                $file = $newFollowing['image'] ?? null;
                $following->image = $this->storeImage2(
                    $request,
                    '/attachments/service_category/event_followings/',
                    $file,
                    'image'
                );

                $following->save();

                foreach (config('translatable.locales') as $lang) {
                    if (! empty($newFollowing[$lang]['title']) || ! empty($newFollowing[$lang]['description'])) {
                        EventFollowingTranslation::create([
                            'event_following_id' => $following->id,
                            'locale'             => $lang,
                            'title'              => $newFollowing[$lang]['title']       ?? '',
                            'description'        => $newFollowing[$lang]['description'] ?? '',
                        ]);
                    }
                }
            }
        }

    if ($request->gallery_image) {
        $group = GalleryGroup::create([
            'type' => 2,
            'status' => 1,
            'foreign_key' => $serviceCategory->id,
            'created_by' => auth()->id(),
        ])->refresh();
        if ($request->gallery) {
            $group->update($request->gallery);
        }
        if ($request->gallery_image) {
            $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $serviceCategoryRequest->gallery_image, 'gallery_image');
            $imgArr = [];
            foreach ($request->gallery_image as $keyImg => $valImg) {
                $imgArr[] = new Gallery([
                    'type' => 2,
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
    }

    if ($request->occasions) {
        $serviceCategory->occasions()->attach($request->occasions);
    }

    session()->flash('success', trans('message.admin.created_sucessfully'));
    return redirect(LaravelLocalization::localizeURL(route('admin.events.index')));
}




    public function edit($id)
    {
        $service_category = ServiceCategory::with('galleryGroup.images' , 'occasions', 'getFollowings.translations')->find($id);
        $occasions = Occasion::latest()->where('type', 1)->active()->get();
        return view('admin/dashboard/service_category/events/edit', compact('service_category', 'occasions'));
    }


    public function show($id)
    {
        $service_category = ServiceCategory::with('galleryGroup.images' , 'occasions','getFollowings')->find($id);
        $occasions = Occasion::latest()->where('type', 1)->active()->get();
        return view('admin/dashboard/service_category/events/show', compact('service_category', 'occasions'));
    }



    public function update($id, Request $request , ServiceCategoryRequest $serviceCategoryRequest)
    {

        $serviceCategory = ServiceCategory::find($id);
        $serviceCategory->update([

            'sort' => $request->sort??0,
            'feature' => $request->feature??0,
            'status' => $request->status??0,
            'updated_by' => auth()->id(),
        ]);
    $serviceCategory->update($serviceCategoryRequest->getSanitized());

 

        if ($request->image) {
            $img = $this->storeImage2($request, $this->product_categoryPath, $request->image, 'image');
            $serviceCategory->image = $img;
            $serviceCategory->save();
        }

        

        if ($request->filled('following')) {
            foreach ($request->following as $followingId => $data) {
                $following = EventFollowing::find($followingId);
                if (! $following) {
                    continue;
                }

                $file = $data['image'] ?? null;
                if ($file instanceof UploadedFile) {
                    $following->image = $this->storeImage2(
                        $request,
                        '/attachments/service_category/event_followings/',
                        $file,
                        'image'
                    );
                }

                $following->save();

                foreach (config('translatable.locales') as $lang) {
                    if (isset($data[$lang])) {
                        EventFollowingTranslation::updateOrCreate(
                            [
                                'event_following_id' => $following->id,
                                'locale'             => $lang,
                            ],
                            [
                                'title'       => $data[$lang]['title']       ?? '',
                                'description' => $data[$lang]['description'] ?? '',
                            ]
                        );
                    }
                }
            }
        }

        if ($request->filled('new_following')) {
            foreach ($request->new_following as $newFollowing) {
                $following = new EventFollowing();
                $following->event_id = $serviceCategory->id;

                $file = $newFollowing['image'] ?? null;
                $following->image = $this->storeImage2(
                    $request,
                    '/attachments/service_category/event_followings/',
                    $file,
                    'image'
                );

                $following->save();

                foreach (config('translatable.locales') as $lang) {
                    if (! empty($newFollowing[$lang]['title']) || ! empty($newFollowing[$lang]['description'])) {
                        EventFollowingTranslation::create([
                            'event_following_id' => $following->id,
                            'locale'             => $lang,
                            'title'              => $newFollowing[$lang]['title']       ?? '',
                            'description'        => $newFollowing[$lang]['description'] ?? '',
                        ]);
                    }
                }
            }
        }


        foreach (config('translatable.locales') as $lang) {

            $translat = $serviceCategory->translations()->where('locale', $lang)->first();

            if ($translat && $translat->id) {
                $translat->update([
                    'service_cat_id' => $serviceCategory->id,
                    'locale' => $lang,
                    'title' => $request->$lang['title'] ?? '',
                    'slug' => $request->$lang['slug'] ?? '',
                    'description' => $request->$lang['description'] ?? '',

                    'middle_title' => $request->$lang['middle_title'] ?? '',
                    'middle_content' => $request->$lang['middle_content'] ?? '',

                    'meta_title' => $request->$lang['meta_title'] ?? '',
                    'meta_desc' => $request->$lang['meta_desc'] ?? '',
                    'meta_key' => $request->$lang['meta_key'] ?? '',
                ]);

            } else {
                ServiceCategoryTranslation::create([
                    'service_cat_id' => $serviceCategory->id,
                    'locale' => $lang,
                    'title' => $request->$lang['title'] ?? '',
                    'slug' => $request->$lang['slug'] ?? '',
                    'description' => $request->$lang['description'] ?? '',

                    'middle_title' => $request->$lang['middle_title'] ?? '',
                    'middle_content' => $request->$lang['middle_content'] ?? '',

                    'meta_title' => $request->$lang['meta_title'] ?? '',
                    'meta_desc' => $request->$lang['meta_desc'] ?? '',
                    'meta_key' => $request->$lang['meta_key'] ?? '',
                ]);

            }
        }


        /**##############################**/


        if ($serviceCategory->galleryGroup && $request->group_title) {

            if ($serviceCategory->galleryGroup->translations() && $serviceCategory->galleryGroup->translations()->count()) {
                $serviceCategory->galleryGroup->translations()->delete();
            }


            $serviceCategory->galleryGroup->translations()->create([
                'gallery_group_id' => $serviceCategory->galleryGroup->id,
                'locale' => 'ar',
                'title' => $request->group_title,
            ]);
            $serviceCategory->galleryGroup->translations()->create([
                    'gallery_group_id' => $serviceCategory->galleryGroup->id,
                    'locale' => 'en',
                    'title' => $request->group_title_en ?? '',
                ]
            );




        }


        if ($request->gallery_image) {
            if ($serviceCategory->galleryGroup && $serviceCategory->galleryGroup->images) {
                $group = $serviceCategory->galleryGroup;

            } else {
                $group = GalleryGroup::create([
                    'type' => 2,
                    'title' => $request->group_title,
                    'title_en' => $request->group_title_en,

                    'status' => 1,
                    'foreign_key' => $serviceCategory->id,
                    'created_by' => auth()->id(),
                ])->refresh();
            }


            $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');

            $imgArr = [];
            foreach ($request->gallery_image as $keyImg => $valImg) {
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
            $serviceCategory->occasions()->sync($request->occasions);
        }


        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }



    public function destroyImage($id)
    {

        $img = Gallery::find($id);
        $this->deleteImageOfGallery($img->path("service_category"), $img, 'image');

        $img->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();


    }
    public function destroyFollowing($id)
{
    $following = EventFollowing::find($id);
    if ($following) {
        if ($following->image) {
            $this->deleteImageOfGallery($following->path(), $following, 'image');
        }
        $following->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
    }
    return redirect()->back();
}











    public function updateFeature($id)
    {
        $serviceCategory = ServiceCategory::find($id);
        if ($serviceCategory->feature < 1) {
            $serviceCategory->feature = 1;
        } else {
            $serviceCategory->feature = 0;
        }
        $serviceCategory->save();
        session()->flash('success', trans('message.admin.featured_changed_sucessfully'));
        return redirect()->back();
    }


    public function updateStatus($id)
    {
        $serviceCategory = ServiceCategory::find($id);
        if ($serviceCategory->status < 1) {
            $serviceCategory->status = 1;
        } else {
            $serviceCategory->status = 0;
        }
        $serviceCategory->save();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();


    }


    /***********################################################***************/

    public function actions(Request $request)
    {

        if ($request['publish'] == 1) {
            $serviceCategorys = ServiceCategory::findMany($request['record']);
            foreach ($serviceCategorys as $serviceCategory) {
                $serviceCategory->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $serviceCategorys = Occasion::findMany($request['record']);
            foreach ($serviceCategorys as $serviceCategory) {
                $serviceCategory->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $serviceCategorys = ServiceCategory::findMany($request['record']);
            foreach ($serviceCategorys as $serviceCategory) {
                if ($serviceCategory->path() . $serviceCategory->image) {
                    $img = $this->deleteImage($serviceCategory, 'image');

                    @unlink($serviceCategory->path() . $serviceCategory->image);
                    $serviceCategory->delete();
                }
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


}

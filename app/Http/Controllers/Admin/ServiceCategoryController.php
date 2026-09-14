<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pages;
use App\Models\Gallery;
use App\Models\Occasion;
use App\Traits\FileHandler;
use App\Models\GalleryGroup;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\PagesTranslation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\AppServiceProvider;
use App\Models\GalleryGroupTranslation;
use App\Models\ServiceCategoryFollowing;
use App\Models\ServiceCategoryTranslation;
use App\Providers\LanguageServiceProvider;
use App\Http\Requests\Admin\ServiceCategoryRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ServiceCategoryController extends Controller
{
    use FileHandler;
    public $serviceCategory_categoryPath;
    public $galleryPath;


    public function __construct()
    {
        $this->serviceCategory_categoryPath = '/attachments/service_category/main_images/';
        $this->galleryPath = "/attachments/gallery/service_category/";
    }


    public function index(Request $request)
    {


        $query = ServiceCategory::query()->with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->orderBy('id', 'DESC');


        if ($request->feature != '') {
            $query = $query->where('feature', $request->feature);
        }

        if ($request->status != '') {
            if ($request->status == 1) $query->where('status', $request->status);
            else {
                $query->where('status', '!=', 1);
            }
        }
        if ($request->title != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }

        if ($request->description != '') {
            $query = $query->orWhereTranslationLike('description', '%' . request()->input('description') . '%');
        }


        /*************************search of date******************/
        if ($request->from_date && $request->to_date) {
            $from = date($request->from_date);
            $to = date($request->to_date);
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }
        if ($request->from_date != '' && $request->to_date == '') {
            $from = date($request->from_date);
            $to = now();
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }

        if ($request->to_date != '' && $request->from_date == '') {
            $from = date("1-1-2000");
            $to = date($request->to_date);
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }

        /*************************search of date******************/


        $items = $query->paginate($this->pagination_count);

        return view('admin/dashboard/service_category/index')->with(['items' => $items]);
    }


    public function create()
    {
        $occasions = Occasion::where('type', 1)->latest()->active()->get();
        return view('admin/dashboard/service_category/create', compact('occasions'));
    }


    // public function store(ServiceCategoryRequest $request)
    // {
    //     $img = $this->storeImage2($request, $this->serviceCategory_categoryPath, $request->image, 'image');

    //       $serviceCategory = ServiceCategory::create($request->getSanitized());

    //     $serviceCategory->image = $img;

    //     $serviceCategory->created_by = auth()->id();
    //     $serviceCategory->save();
    //     if ($request->gallery_image) {
    //         $group = GalleryGroup::create([
    //             'type' => 2,
    //             'status' => 1,
    //             'foreign_key' => $serviceCategory->id,
    //             'created_by' => auth()->id(),
    //         ])->refresh();
    //         if ($request->gallery) {
    //             $group->update($request->gallery);
    //         }


    //         if ($request->gallery_image) {
    //             $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');
    //             $imgArr = [];
    //             foreach ($request->gallery_image as $keyImg => $valImg) {
    //                 //               $imgItem =  $this->storeImage2($request , "/attachments/gallery/products/" , $request->gallery_image[$keyImg] , 'gallery_image');
    //                 $imgArr[] = new Gallery([
    //                     'type' => 2,
    //                     'image' => $all_images_returned_arr[$keyImg] ?? '',
    //                     'sort' => $request->gallery_sort[$keyImg] ?? '',
    //                     'gallery_group_id' => $group->id,
    //                     'feature' => isset($request->gallery_feature[$keyImg]) ? (int)$request->gallery_feature[$keyImg] : 0,
    //                     'status' => 1,
    //                     'created_by' => auth()->id(),
    //                 ]);
    //             }
    //         }


    //         $group->images()->saveMany($imgArr);
    //     }


    //     if ($request->occasions) {
    //         $serviceCategory->occasions()->attach($request->occasions);
    //     }

    //     session()->flash('success', trans('message.admin.created_sucessfully'));
    //     return redirect(LaravelLocalization::localizeURL(route('admin.service.index')));

        
      

    // }

    public function store(ServiceCategoryRequest $request)
    {
        $data = $request->getSanitized();

        $serviceCategory = ServiceCategory::create($data);

        if ($request->hasFile('gallery_image')) {
            $group = GalleryGroup::create([
                'type'        => 2,
                'status'      => 1,
                'foreign_key' => $serviceCategory->id,
                'created_by'  => Auth::id(),
            ])->refresh();

            if ($request->filled('gallery')) {
                $group->update($request->input('gallery'));
            }

            $filenames = $this->storeImageMulti(
                $request,
                $this->galleryPath,
                $request->file('gallery_image'),
                'gallery_image'
            );

            $items = [];
            foreach ($filenames as $i => $filename) {
                $items[] = new Gallery([
                    'type'             => 2,
                    'image'            => $filename,
                    'sort'             => $request->input("gallery_sort.$i", null),
                    'feature'          => (int) $request->input("gallery_feature.$i", 0),
                    'status'           => 1,
                    'created_by'       => Auth::id(),
                    'gallery_group_id' => $group->id,
                ]);
            }
            $group->images()->saveMany($items);
        }

        if ($request->filled('occasions')) {
            $serviceCategory->occasions()->attach($request->input('occasions'));
        }

        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect(
            LaravelLocalization::localizeURL(route('admin.service.index'))
        );
    }



    


    public function edit($id)
    {
        $service_category = ServiceCategory::with('galleryGroup.images', 'occasions', 'followings')->find($id);
        $occasions = Occasion::latest()->where('type', 1)->active()->get();
        return view('admin/dashboard/service_category/edit', compact('service_category', 'occasions'));
    }


    public function show($id)
    {
        $service_category = ServiceCategory::with('galleryGroup.images', 'occasions')->find($id);
        $occasions = Occasion::latest()->where('type', 1)->active()->get();
        return view('admin/dashboard/service_category/show', compact('service_category', 'occasions'));
    }


//     public function update($id, ServiceCategoryRequest $request)
//     {
//        $serviceCategory = ServiceCategory::findOrFail($id);
//     $serviceCategory->update($request->getSanitized());
//         if ($serviceCategory->galleryGroup) {
//             $groupGallery = $serviceCategory->galleryGroup;
//         } else {
//             $groupGallery = GalleryGroup::create([
//                 'type' => 2,
//                 'status' => 1,
//                 'foreign_key' => $serviceCategory->id,
//                 'updated_by' => auth()->id(),
//             ])->refresh();
//         }
//         if ($request->hasFile('info_image')) {
//             $img = $this->storeImage2($request, '/attachments/service_category/info_images/', $request->info_image, 'info_image');
//             $serviceCategory->info_image = $img;
//             $serviceCategory->save();
//         }



//         if ($request->gallery) {
//             $groupGallery->update($request->gallery);
//         }

//         $group = $groupGallery;

//         if ($request->gallery_image) {
//             $all_images_returned_arr = $this->storeImageMulti($request, $this->galleryPath, $request->gallery_image, 'gallery_image');

//             $imgArr = [];
//             foreach ($request->gallery_image as $keyImg => $valImg) {
//                 $imgArr[] = new Gallery([
//                     'image' => $all_images_returned_arr[$keyImg] ?? '',
//                     'sort' => $request->gallery_sort[$keyImg] ?? '',
//                     'gallery_group_id' => $group->id,
//                     'feature' => isset($request->gallery_feature[$keyImg]) ? (int)$request->gallery_feature[$keyImg] : 0,
//                     'status' => 1,
//                     'created_by' => auth()->id(),
//                 ]);
//             }
//             $group->images()->saveMany($imgArr);
//         }
//         $request->validate([
//             'new_following.*.image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//             'new_following.*.en.title' => 'nullable|string|max:255',
//             'new_following.*.en.description' => 'nullable|string',
//             'new_following.*.ar.title' => 'nullable|string|max:255',
//             'new_following.*.ar.description' => 'nullable|string',
//         ]);

//         // Update existing followings

//      if ($request->following) {
//     foreach ($request->following as $followingId => $data) {
//         $following = ServiceCategoryFollowing::find($followingId);
//         if (! $following) {
//             continue;
//         }

//         if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
//             $image     = $data['image'];
//             $imageName = time() . '_' . $image->getClientOriginalName();
//             $imagePath = '/attachments/service_category/followings/';
//             $image->move(public_path($imagePath), $imageName);
//             $following->image = $imagePath . $imageName;
//         }

//         $following->save();

//         foreach (config('translatable.locales') as $lang) {
//             if (isset($data[$lang])) {
//                 $trans = $following->translateOrNew($lang);
//                 $trans->title       = $data[$lang]['title']       ?? '';
//                 $trans->description = $data[$lang]['description'] ?? '';
//                 $trans->save();
//             }
//         }

//         $following->save();
//     }
// }


// //        // Create new followings

//         if ($request->new_following) {
//             foreach ($request->new_following as $newFollowing) {
//                 if (isset($newFollowing['image']) && $newFollowing['image'] instanceof \Illuminate\Http\UploadedFile) {
//                     $image = $newFollowing['image'];
//                     $imageName = time() . '_' . $image->getClientOriginalName();
//                     $imagePath = '/attachments/service_category/followings/';
//                     $image->move(public_path($imagePath), $imageName);
//                     $fullPath = $imagePath . $imageName;

//                     $following = ServiceCategoryFollowing::create([
//                         'service_category_id' => $serviceCategory->id,
//                         'image' => $fullPath,
//                     ]);

//                     foreach (config('translatable.locales') as $lang) {
//                         if (isset($newFollowing[$lang])) {
//                             $following->translateOrNew($lang)->title = $newFollowing[$lang]['title'] ?? '';
//                             $following->translateOrNew($lang)->description = $newFollowing[$lang]['description'] ?? '';
//                         }
//                     }
//                     $following->save();
//                 }
//             }
//         }
//         if ($request->occasions) {
//             $serviceCategory->occasions()->sync($request->occasions);
//         }


//         session()->flash('success', trans('message.admin.updated_sucessfully'));
//         return redirect()->back();
//     }



 public function update($id, ServiceCategoryRequest $request)
    {
        $serviceCategory = ServiceCategory::findOrFail($id);
        $serviceCategory->update($request->getSanitized());

        $group = $serviceCategory->galleryGroup
            ?? GalleryGroup::create([
                   'type'        => 2,
                   'status'      => 1,
                   'foreign_key' => $serviceCategory->id,
                   'created_by'  => Auth::id(),
               ])->refresh();

        if ($request->filled('gallery')) {
            $group->update($request->input('gallery'));
        }

        if ($request->hasFile('gallery_image')) {
            $filenames = $this->storeImageMulti(
                $request,
                $this->galleryPath,
                $request->file('gallery_image'),
                'gallery_image'
            );
            $items = [];
            foreach ($filenames as $i => $filename) {
                $items[] = new Gallery([
                    'image'            => $filename,
                    'sort'             => $request->input("gallery_sort.$i", null),
                    'feature'          => (int) $request->input("gallery_feature.$i", 0),
                    'status'           => 1,
                    'created_by'       => Auth::id(),
                    'gallery_group_id' => $group->id,
                ]);
            }
            $group->images()->saveMany($items);
        }

             if ($request->following) {
    foreach ($request->following as $followingId => $data) {
        $following = ServiceCategoryFollowing::find($followingId);
        if (! $following) {
            continue;
        }

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $image     = $data['image'];
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = '/attachments/service_category/followings/';
            $image->move(public_path($imagePath), $imageName);
            $following->image = $imagePath . $imageName;
        }

        $following->save();

        foreach (config('translatable.locales') as $lang) {
            if (isset($data[$lang])) {
                $trans = $following->translateOrNew($lang);
                $trans->title       = $data[$lang]['title']       ?? '';
                $trans->description = $data[$lang]['description'] ?? '';
                $trans->save();
            }
        }

        $following->save();
    }
}
               if ($request->new_following) {
            foreach ($request->new_following as $newFollowing) {
                if (isset($newFollowing['image']) && $newFollowing['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $image = $newFollowing['image'];
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = '/attachments/service_category/followings/';
                    $image->move(public_path($imagePath), $imageName);
                    $fullPath = $imagePath . $imageName;

                    $following = ServiceCategoryFollowing::create([
                        'service_category_id' => $serviceCategory->id,
                        'image' => $fullPath,
                    ]);

                    foreach (config('translatable.locales') as $lang) {
                        if (isset($newFollowing[$lang])) {
                            $following->translateOrNew($lang)->title = $newFollowing[$lang]['title'] ?? '';
                            $following->translateOrNew($lang)->description = $newFollowing[$lang]['description'] ?? '';
                        }
                    }
                    $following->save();
                }
            }
        }

        if ($request->filled('occasions')) {
            $serviceCategory->occasions()->sync($request->input('occasions'));
        }

        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroyFollowing($id)
    {
        $following = ServiceCategoryFollowing::findOrFail($id);
        $this->deleteImage($following, 'image');
        $following->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
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


    public function getLandScape()
    {
        $service_category = ServiceCategory::with('galleryGroup.images', 'occasions')->where('service_unique_name', 'landscape')->first();
        if (!$service_category) {
            return redirect()->route('admin.service.create');
        }
        $occasions = Occasion::latest()->where('type', 1)->active()->get();

        // if ($service_category->galleryGroup) {
        //     dd($service_category->galleryGroup->images);  
        // } else {
        //     dd('  no images  ');  
        // }
        return view('admin/dashboard/service_category/edit', compact('service_category', 'occasions'));
    }

        public function updateStatus($id)
    {
        $article = ServiceCategory::findOrfail($id);
        $article->status == 1 ? $article->status = 0 : $article->status = 1;
        $article->save();
        $this->clearHomeCache();
        return redirect()->back();
    }

    public function updateFeature($id)
    {
        $article = ServiceCategory::findOrfail($id);
        $article->feature == 1 ? $article->feature = 0 : $article->feature = 1;
        $article->save();
        $this->clearHomeCache();
        return redirect()->back();
    }

    public function destroy($id)
    {
        $serviceCategory = ServiceCategory::findOrFail($id);
        $this->deleteImage($serviceCategory, 'image');

        if ($serviceCategory->galleryGroup) {
            foreach ($serviceCategory->galleryGroup->images as $img) {
                $this->deleteImageOfGallery($img->path("service_category"), $img, 'image');
                $img->delete();
            }
            $serviceCategory->galleryGroup->delete();
        }

        $serviceCategory->delete();
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }
}

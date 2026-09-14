<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Filter;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Occasion;
use App\Traits\FileHandler;
use App\Models\GalleryGroup;
use Illuminate\Http\Request;
use App\Models\ProductPocket;
use App\Models\ProductCategory;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Exports\ProductsExport;
use App\Models\ProductInfo;
use App\Models\ProductPaymentLine;
use App\Models\ProductTips;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\TranslatableHandler;


class ProductController extends Controller
{
    use FileHandler, TranslatableHandler;
    public $products;
    public $productPath;
    public $galleryPath;



    public function __construct()
    {
        $this->products = Product::with(
            [
                'trans' => function ($q) {
                    $q->where('locale', app()->getLocale());
                }
            ]
        )->with('occasions')->latest()->paginate(20);

        $this->productPath = '/attachments/products/';
        $this->galleryPath = "/attachments/gallery/products/";
    }


    public function index(Request $request)
    {

        if ($request->input('export') === 'excel') {
            return Excel::download(new ProductsExport($request), 'products.xlsx');
        }

        $cats = ProductCategory::with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->active()->latest()->get();
        $query = Product::query()->with('productCategoriesProducts')
            ->with(['translations' => function ($q) {
                $q->where('locale', app()->getLocale());
            }])
            ->ordinary()
            ->orderBy('id', 'DESC');
        $cats = ProductCategory::all();

        // status filter
        if ($request->filled('status')) {
            if ($request->status == 1) {
                $query->where('status', 1);
            } else {
                $query->where('status', '!=', 1);
            }
        }

        // search by title (translations)
        if ($request->filled('title')) {
            $search = '%' . $request->title . '%';
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                    ->where('title', 'LIKE', $search);
            });
        }

        // search by description (translations)
        if ($request->filled('description')) {
            $search = '%' . $request->description . '%';
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                    ->where('description', 'LIKE', $search);
            });
        }

        // search by care_tips (translations)
        if ($request->filled('care_tips')) {
            $search = '%' . $request->care_tips . '%';
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                    ->where('care_tips', 'LIKE', $search);
            });
        }

        // search by code (product column)
        if ($request->filled('code')) {
            $query->where('code', 'LIKE', '%' . $request->code . '%');
        }

        // price filters
        if ($request->filled('from_price') && !$request->filled('to_price')) {
            $query->where('price', '>=', $request->from_price);
        }
        if ($request->filled('to_price') && !$request->filled('from_price')) {
            $query->where('price', '<=', $request->to_price);
        }
        if ($request->filled('from_price') && $request->filled('to_price')) {
            $query->whereBetween('price', [$request->from_price, $request->to_price]);
        }

        // date filters
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = Carbon::parse($request->from_date);
            $to = Carbon::parse($request->to_date);
            $query->whereBetween('created_at', [$from, $to]);
        } elseif ($request->filled('from_date')) {
            $from = Carbon::parse($request->from_date);
            $query->whereDate('created_at', '>=', $from);
        } elseif ($request->filled('to_date')) {
            $to = Carbon::parse($request->to_date);
            $query->whereDate('created_at', '<=', $to);
        }

        // pagination
        $items = $query->paginate($this->pagination_count);


        return view('admin/dashboard/products/index')->with([
            'items' => $items,
            'cats' => $cats
        ]);
    }



    public function show($id)
    {

        $product = Product::with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->ordinary()->find($id);

        if (!$product) {
            session()->flash('error', trans('message.admin.not_found'));
            return redirect()->back(); //here
        }
        return view('admin/dashboard/products/show')->with(['product' => $product]);
    }


    public function create()
    {
        $cats = ProductCategory::with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->ordinary()->active()->latest()->get();

        $occasions = Occasion::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->where('status', 1)->where('type', 0)->active()->latest()->get();


        $filters = Filter::with(['translations' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->get();
        return view('admin/dashboard/products/create', compact('occasions', 'cats', 'filters'));
    }


    public function store(ProductRequest $request)
    {
        $data = $request->getSanitized();

        // dd($data['lines'], @$data['lines']['title']['en'], @$data['lines']['title']['ss']);
        $data['image'] = $this->storeImage2($request, $this->productPath, $request->image, 'image');
        $data['url'] = $request->url;
        $product = Product::create($data);

        $this->saveModelTranslation($product, $data);


        if ($request->has('lines')) {
            foreach ($data['lines'] as $lines) {
                $lineData = [
                    'product_id' => $product->id,
                    'links' => $lines['links'],
                    'color' => $lines['color'],
                    'sort' => $lines['sort'],
                    'status' => $lines['status'] ?? 1,
                    'en' =>  ['title' => @$lines['title']['en']],
                    'ar' =>  ['title' => @$lines['title']['ar']],
                ];
                $line = ProductPaymentLine::create($lineData);
            }
        }

        if ($request->has('tips')) {
            foreach ($data['tips'] as $tips) {
                $tipsData = [
                    'product_id' => $product->id,
                    'sort' => $tips['sort'],
                    'status' => $tips['status'] ?? 1,
                    'en' =>  [
                        'title' => @$tips['title']['en'],
                        'description' => @$tips['description']['en']
                    ],
                    'ar' =>  [
                        'title' => @$tips['title']['ar'],
                        'description' => @$tips['description']['en']
                    ],
                ];
                $tips = ProductTips::create($tipsData);
            }
        }

        if ($request->has('info')) {
            foreach ($data['info'] as $info) {
                $infoData = [
                    'product_id' => $product->id,
                    'sort' => $info['sort'],
                    'status' => $info['status'] ?? 1,
                    'en' =>  [
                        'title' => @$info['title']['en'],
                        'description' => @$info['description']['en']
                    ],
                    'ar' =>  [
                        'title' => @$info['title']['ar'],
                        'description' => @$info['description']['en']
                    ],
                ];
                $info = ProductInfo::create($infoData);
            }
        }

        if ($request->has('has_pockets')) {
            $product->has_pockets = true;
            $product->save();

            if (isset($request->pockets['en']) && isset($request->pockets['ar'])) {
                foreach ($request->pockets['en'] as $index => $pocketNameEn) {
                    if (!isset($request->pockets['ar'][$index])) {
                        continue;
                    }
                    $pocketData = [
                        'product_id' => $product->id,
                        'price' => null,
                    ];

                    $pocket = ProductPocket::create($pocketData);

                    $pocket->translations()->create([
                        'locale' => 'en',
                        'pocket_name' => $pocketNameEn,
                    ]);

                    $pocket->translations()->create([
                        'locale' => 'ar',
                        'pocket_name' => $request->pockets['ar'][$index],
                    ]);
                }
            }
        }

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
        }

        if ($request->occasions) {
            $product->occasions()->attach($request->occasions);
        }

        if ($request->categories) {
            $product->productCategoriesProducts()->attach($request->categories);
        }
        if ($request->filters) {
            $product->filters()->attach($request->filters);
        }

        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect((route('admin.products.index')));
    }


    public function edit($id)
    {
        $product = Product::with('trans', 'pockets.translations')->ordinary()->find($id);


        $cats = ProductCategory::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->ordinary()->active()->latest()->get();

        $occasions = Occasion::with(['trans' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->where('status', 1)->where('type', 0)->latest()->get();

        $filters = Filter::with(['translations' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->get();


        return view('admin/dashboard/products/edit')->with(['product' => $product, 'occasions' => $occasions, 'cats' => $cats, 'filters' => $filters]);
    }


    public function update(Product $product, ProductRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->updateImage($request, $product, $product->path('products'), $request->image, 'image');
        }
        $data['url'] = $request->url;

        if ($request->has('filters')) {
            $product->filters()->sync($request->filters);
        } else {
            $product->filters()->detach();
        }

        $product->update($data);
        $this->saveModelTranslation($product, $data);

        // paymentLine ---------------------------------------------------
        if ($request->has('lines')) {
            $submittedLineIds = collect($data['lines'])
                ->pluck('id')
                ->filter() 
                ->toArray();

            ProductPaymentLine::where('product_id', $product->id)
                ->whereNotIn('id', $submittedLineIds)
                ->delete();

            foreach ($data['lines'] as $tipData) {
                $tipAttributes = [
                    'product_id' => $product->id,
                    'color' => @$tipData['color'],
                    'links' => @$tipData['links'],
                    'sort' => @$tipData['sort'],
                    'status' => @$tipData['status'] ?? 1,
                ];
                $translations = [
                    'en' => [
                        'title' => @$tipData['title']['en'],
                        'description' => @$tipData['description']['en']
                    ],
                    'ar' => [
                        'title' => @$tipData['title']['ar'],
                        'description' => @$tipData['description']['ar']
                    ],
                ];
                $fullTipData = array_merge($tipAttributes, $translations);
                if (isset($tipData['id']) && $tipData['id']) {
                    $tip = ProductPaymentLine::find($tipData['id']);
                    if ($tip) {
                        $tip->update($fullTipData);
                    }
                } else {
                    $tip = ProductPaymentLine::create($fullTipData);
                }
            }
        } else {
            ProductPaymentLine::where('product_id', $product->id)->delete();
        }
        // paymentLine ---------------------------------------------------


        // Product Tips ---------------------------------------------------
        if ($request->has('tips')) {
            $submittedTipIds = collect($data['tips'])
                ->pluck('id')
                ->filter() 
                ->toArray();

            ProductTips::where('product_id', $product->id)
                ->whereNotIn('id', $submittedTipIds)
                ->delete();

            foreach ($data['tips'] as $tipData) {
                $tipAttributes = [
                    'product_id' => $product->id,
                    'sort' => @$tipData['sort'],
                    'status' => @$tipData['status']?? 1,
                ];
                $translations = [
                    'en' => [
                        'title' => @$tipData['title']['en'],
                        'description' => @$tipData['description']['en']
                    ],
                    'ar' => [
                        'title' => @$tipData['title']['ar'],
                        'description' => @$tipData['description']['ar']
                    ],
                ];
                $fullTipData = array_merge($tipAttributes, $translations);
                if (isset($tipData['id']) && $tipData['id']) {
                    $tip = ProductTips::find($tipData['id']);
                    if ($tip) {
                        $tip->update($fullTipData);
                    }
                } else {
                    $tip = ProductTips::create($fullTipData);
                }
            }
        } else {
            ProductTips::where('product_id', $product->id)->delete();
        }
        // Product Tips ---------------------------------------------------

         // Product Tips ---------------------------------------------------
        if ($request->has('info')) {
            $submittedTipIds = collect($data['info'])
                ->pluck('id')
                ->filter() 
                ->toArray();

            ProductInfo::where('product_id', $product->id)
                ->whereNotIn('id', $submittedTipIds)
                ->delete();

            foreach ($data['info'] as $tipData) {
                $tipAttributes = [
                    'product_id' => $product->id,
                    'sort' => @$tipData['sort'],
                    'status' => @$tipData['status']?? 1,
                ];
                $translations = [
                    'en' => [
                        'title' => @$tipData['title']['en'],
                        'description' => @$tipData['description']['en']
                    ],
                    'ar' => [
                        'title' => @$tipData['title']['ar'],
                        'description' => @$tipData['description']['ar']
                    ],
                ];
                $fullTipData = array_merge($tipAttributes, $translations);
                if (isset($tipData['id']) && $tipData['id']) {
                    $tip = ProductInfo::find($tipData['id']);
                    if ($tip) {
                        $tip->update($fullTipData);
                    }
                } else {
                    $tip = ProductInfo::create($fullTipData);
                }
            }
        } else {
            ProductInfo::where('product_id', $product->id)->delete();
        }
        // Product Tips ---------------------------------------------------

        if ($request->has('has_pockets')) {
            $pocketIdsToKeep = [];
            
            
            $pockets = $request->input('pockets', []);
            
            foreach ($pockets['en'] as $index => $item) {
                $pocketData = [
                    'product_id' => $product->id,
                    'price'      =>  0,
                ];

                $pocketId = $pockets['id'][$index] ?? null;
                if ($pocketId && $pocketId !== 'new') {
                    $pocket = ProductPocket::find($pocketId);
                    if ($pocket) {
                        $pocket->update($pocketData);
                        $pocketIdsToKeep[] = $pocket->id;
                    } else {
                        // fallback: create if id provided but not found
                        $pocket = ProductPocket::create($pocketData);
                        $pocketIdsToKeep[] = $pocket->id;
                    }
                } else {
                    $pocket = ProductPocket::create($pocketData);
                    $pocketIdsToKeep[] = $pocket->id;
                }


                $enName = $pockets['en'][$index] ?? null;
                $arName = $pockets['ar'][$index] ?? null;

                if ($enName !== null) {
                    $pocket->translations()->updateOrCreate(
                        ['locale' => 'en'],
                        ['pocket_name' => $enName]
                    );
                }
                if ($arName !== null) {
                    $pocket->translations()->updateOrCreate(
                        ['locale' => 'ar'],
                        ['pocket_name' => $arName]
                    );
                }
            }

            ProductPocket::where('product_id', $product->id)
                ->whereNotIn('id', $pocketIdsToKeep)
                ->delete();
        } 

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

        if ($request->occasions) {
            $product->occasions()->sync($request->occasions);
        }

        if ($request->categories) {
            $product->productCategoriesProducts()->sync($request->categories);
        }

        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    // public function deletePocketImage($pocketId, $imageName)
    // {
    //     $pocket = ProductPocket::findOrFail($pocketId);

    //     $imagePath = public_path('attachments/pockets/' . $imageName);
    //     if (file_exists($imagePath)) {
    //         unlink($imagePath);
    //     }

    //     $images = json_decode($pocket->image, true) ?? [];
    //     $updatedImages = array_filter($images, fn($img) => $img !== $imageName);

    //     if (empty($updatedImages)) {
    //         $pocket->image = null;
    //     } else {
    //         $pocket->image = json_encode(array_values($updatedImages));
    //     }

    //     $pocket->save();

    //     return response()->json(['success' => true]);
    // }
    public function destroy(Product $product)
    {

        $this->deleteImage($product, 'image');
        $product->update(['updated_by' => auth()->id()]);
        $product->trans()->delete();
        $product->delete();
        $this->clearHomeCache();

        session()->flash('danger', trans('message.admin.deleted_sucessfully'));
        return redirect((route('admin.products.index')));
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
        $this->clearHomeCache();
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
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();
    }
    public function updateshow_in_slider($id)
    {
        $product = Product::find($id);
        if ($product->show_in_slider < 1) {
            $product->show_in_slider = 1;
        } else {
            $product->show_in_slider = 0;
        }
        $product->updated_by = auth()->id();
        $product->save();
        session()->flash('success', trans('message.admin.show_in_slider_changed_sucessfully'));
        return redirect()->back();
    }
    public function updateshow_text($id)
    {
        $product = Product::find($id);
        if ($product->show_text < 1) {
            $product->show_text = 1;
        } else {
            $product->show_text = 0;
        }
        $product->updated_by = auth()->id();
        $product->save();
        session()->flash('success', trans('message.admin.show_text_changed_sucessfully'));
        return redirect()->back();
    }
    public function updateuser_input($id)
    {
        $product = Product::find($id);
        if ($product->user_input < 1) {
            $product->user_input = 1;
        } else {
            $product->user_input = 0;
        }
        $product->updated_by = auth()->id();
        $product->save();
        session()->flash('success', trans('message.admin.user_input_changed_sucessfully'));
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
        $this->clearHomeCache();
        return redirect()->back();
    }


    public function reports(Request $request)
    {


        $query = Order::query();

        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = Carbon::parse($request->input('from_date'));
            $toDate = Carbon::parse($request->input('to_date'))->endOfDay();
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $totalOrders = $query->count();
        $totalSum = $query->sum('total');

        $occasions = Occasion::with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->where('type', 0)->active()->latest()->get();

        $cats = ProductCategory::with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->active()->latest()->get();


        $query = Product::query()->with('occasions', 'productCategoriesProducts')->with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->with('occasions')->ordinary()->orderBy('id', 'DESC');


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
        if ($request->care_tips != '') {
            $query = $query->whereTranslationLike('care_tips', '%' . request()->input('care_tips') . '%');
        }


        if ($request->code != '') {
            $query = $query->where('code', 'like', '%' . request()->input('code') . '%');
        }

        if ($request->rate) {
            $query->whereHas('rates', function ($query) use ($request) {
                $query->select(DB::raw('AVG(rating_value) as avg_rating_value'))
                    ->groupBy('product_id')
                    ->having(DB::raw('AVG(rating_value)'), 'like', '%' . $request->rate . '%');
            });
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
        //        if ($request->from_date && $request->to_date) {
        //            $from = date($request->from_date);
        //            $to = date($request->to_date);
        //            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        //        }
        //        if ($request->from_date != '' && $request->to_date == '') {
        //            $from = date($request->from_date);
        //            $to = now();
        //            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        //        }
        //
        //        if ($request->to_date != '' && $request->from_date == '') {
        //            $from = date("1-1-2000");
        //            $to = date($request->to_date);
        //            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        //        }
        //
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


        /*************************search of date******************/


        if ($request->occasions != '') {
            $query = $query->whereHas('occasions', function ($q) {
                $q->whereTranslationLike('title', request()->input('occasions'));
            });
        }

        if ($request->cat_id != '') {
            $query = $query->whereHas('productCategoriesProducts', function ($q) {
                //    $q->where('id', request()->input('cat_id'));
                $q->whereTranslationLike('title', request()->input('cat_id'));
            });
        }

        $items = $query->withSum('orderDetails', 'quantity')->withSum('orderDetails', 'total')->withAvg('rates', 'rating_value')->paginate($this->pagination_count);
        // dd($items->first()->productCategoriesProducts);


        return view('admin/dashboard/reports/products/index')->with(['items' => $items, 'occasions' => $occasions, 'cats' => $cats, 'totalSum' => $totalSum, 'totalOrders' => $totalOrders]);
    }

    // في App\Http\Controllers\Admin\ProductController
    public function updateFeatured(Request $request)
    {
        Product::query()->update([
            'most_selling' => 0,
            'best_offer' => 0
        ]);

        if ($request->has('most_selling')) {
            Product::whereIn('id', $request->most_selling)->update(['most_selling' => 1]);
        }

        if ($request->has('best_offer')) {
            Product::whereIn('id', $request->best_offer)->update(['best_offer' => 1]);
        }

        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }
    public function featuredProducts()
    {
        $products = Product::with(['transNow' => function ($query) {
            $query->select('product_id', 'title');
        }])->get();

        return view('admin.products.featured', compact('products'));
    }
}

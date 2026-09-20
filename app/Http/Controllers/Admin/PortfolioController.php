<?php

namespace App\Http\Controllers\Admin;

use App\Models\Portfolios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioRequest;
use App\Models\PortfolioTags;
use App\Models\Tag;
use App\Models\Gallery;
use App\Models\GalleryGroup;
use App\Traits\FileHandler;

class PortfolioController extends Controller
{
    use FileHandler;
    public $tags;



    public $galleryPath;

    public function __construct()
    {
        $this->tags = PortfolioTags::query()->with('trans')->get();
        $this->galleryPath = "/attachments/gallery/portfolios/";
    }

    public function index(Request $request)
    {

        $query = Portfolios::query()->with('trans', 'tag')->orderBy('id', 'ASC');
        $tags = $this->tags;

        if ($request->status  != '') {
            if ($request->status == 1) $query->where('status', $request->status);
            else {
                $query->where('status', '!=', 1);
            }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }

        if ($request->tag_id != '') {
            $query = $query->where('tag_id',  request()->input('tag_id'));
        }

        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.portfolio.index', compact('items', 'tags'));
    }

    public function create()
    {
        $tags = $this->tags;
        return view('admin.dashboard.portfolio.create', compact('tags'));
    }


    public function store(PortfolioRequest $request)
    {
        $data = $request->getSanitized();
        unset($data['image']);
        $data['video_url'] = $request->type === 'video' ? $request->input('video_url') : null;

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), 'portfolio');
        }

        $portfolio = Portfolios::create($data);

        if ($request->hasFile('gallery_image')) {
            if ($portfolio->galleryGroup) {
                $group = $portfolio->galleryGroup;
            } else {
                $group = GalleryGroup::create([
                    'type' => 2,
                    'status' => 1,
                    'foreign_key' => $portfolio->id,
                    'created_by' => auth()->id(),
                ])->refresh();
            }

            if ($request->has('gallery')) {
                $group->update($request->gallery);
            }
            $galleryTypes = [];

            foreach ($request->gallery_image as $keyImg => $file) {
                $galleryTypes[$keyImg] = $this->detectMediaType($file);
            }
            $allImages = $this->storeImageMulti(
                $request,
                $this->galleryPath,
                $request->gallery_image,
                'gallery_image'
            );

            $imgArr = [];

            foreach ($request->gallery_image as $keyImg => $valImg) {
                $imgArr[] = new Gallery([
                    'image' => $allImages[$keyImg] ?? '',
                    'type' => $galleryTypes[$keyImg] ?? 'image',
                    'sort' => $request->gallery_sort[$keyImg] ?? 0,
                    'gallery_group_id' => $group->id,
                    'feature' => isset($request->gallery_feature[$keyImg]) ? 1 : 0,
                    'status' => 1,
                    'created_by' => auth()->id(),
                ]);
            }

            $group->images()->saveMany($imgArr);
        }

        session()->flash('success', trans('message.admin.created_sucessfully'));

        return redirect()->route('admin.portfolio.edit', $portfolio->id);
    }


    public function show(Portfolios $portfolio)
    {


        return view('admin.dashboard.portfolio.show', compact('portfolio'));
    }


    public function edit(Portfolios $portfolio)
    {
        $tags = $this->tags;
        return view('admin.dashboard.portfolio.edit', compact('portfolio', 'tags'));
    }


    public function update(PortfolioRequest $request, Portfolios $portfolio)
    {
        $data = $request->getSanitized();
        unset($data['image']);
        $data['video_url'] = $request->type === 'video' ? $request->input('video_url') : null;

        if ($request->hasFile('image')) {
            $this->deletePublicFile($portfolio->image);
            $data['image'] = $this->upload_file($request->file('image'), 'portfolio');
        }

        $portfolio->update($data);
        if ($request->has('old_gallery_sort') && is_array($request->old_gallery_sort)) {
            $groupId = $portfolio->galleryGroup ? $portfolio->galleryGroup->id : null;

            if ($groupId) {
                foreach ($request->old_gallery_sort as $galleryId => $sort) {
                    Gallery::where('id', $galleryId)
                        ->where('gallery_group_id', $groupId)
                        ->update([
                            'sort' => $sort ?? 0,
                            
                        ]);
                }
            }
        }

        if ($request->hasFile('gallery_image')) {
            if ($portfolio->galleryGroup) {
                $group = $portfolio->galleryGroup;
            } else {
                $group = GalleryGroup::create([
                    'type' => 2,
                    'status' => 1,
                    'foreign_key' => $portfolio->id,
                    'created_by' => auth()->id(),
                ])->refresh();
            }

            if ($request->has('gallery')) {
                $group->update($request->gallery);
            }
            $galleryTypes = [];

            foreach ($request->gallery_image as $keyImg => $file) {
                $galleryTypes[$keyImg] = $this->detectMediaType($file);
            }
            $allImages = $this->storeImageMulti(
                $request,
                $this->galleryPath,
                $request->gallery_image,
                'gallery_image'
            );

            $imgArr = [];

            foreach ($request->gallery_image as $keyImg => $valImg) {
                $imgArr[] = new Gallery([
                    'image' => $allImages[$keyImg] ?? '',
                    'type' => $galleryTypes[$keyImg] ?? 'image',
                    'sort' => $request->gallery_sort[$keyImg] ?? 0,
                    'gallery_group_id' => $group->id,
                    'feature' => isset($request->gallery_feature[$keyImg]) ? 1 : 0,
                    'status' => 1,
                    'created_by' => auth()->id(),
                ]);
            }

            $group->images()->saveMany($imgArr);
        }

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Portfolios $portfolio)
    {
        $this->deletePublicFile($portfolio->image);
        $portfolio->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

    public function destroyImage($id)
    {
        $image = Gallery::findOrFail($id);

        $filePath = public_path($image->pathInView('portfolios'));

        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        $image->delete();

        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }
    private function detectMediaType($file)
    {
        if (!$file) {
            return 'image';
        }

        $ext = strtolower($file->getClientOriginalExtension());

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
            return 'image';
        }

        if (in_array($ext, ['mp4', 'mov', 'avi', 'mkv'])) {
            return 'video';
        }

        if ($ext === 'pdf') {
            return 'pdf';
        }

        return 'other';
    }
    public function update_status($id)
    {
        $portfolio = Portfolios::findOrfail($id);
        $portfolio->status == 1 ? $portfolio->status = 0 : $portfolio->status = 1;
        $portfolio->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $portfolio = Portfolios::findOrfail($id);
        $portfolio->feature == 1 ? $portfolio->feature = 0 : $portfolio->feature = 1;
        $portfolio->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $portfolios = Portfolios::findMany($request['record']);
            foreach ($portfolios as $portfolio) {
                $portfolio->update(['status' => 1]);
            }
            session()->flash('success', trans('portfolio.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $portfolios = Portfolios::findMany($request['record']);
            foreach ($portfolios as $portfolio) {
                $portfolio->update(['status' => 0]);
            }
            session()->flash('success', trans('portfolio.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $portfolios = Portfolios::findMany($request['record']);
            foreach ($portfolios as $portfolio) {
                $this->deletePublicFile($portfolio->image);
                $portfolio->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }

    private function deletePublicFile(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path(ltrim($path, '/'));

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}

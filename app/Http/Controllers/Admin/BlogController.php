<?php
// app/Http/Controllers/Admin/BlogController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\Blog\StoreBlogRequest;
use App\Http\Requests\Admin\Blog\UpdateBlogRequest;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query  = Blog::with('translations')
            ->orderBy('id', 'DESC');


        if ($request->filled('title')) {
            $query->whereTranslationLike('title', '%' . $request->title . '%');
        }
        $blogs = $query->paginate(20)->appends($request->only(['title']));


        return view('admin.dashboard.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.dashboard.blogs.create');
    }

    public function store(StoreBlogRequest $request)
    {

        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(Blog::diskPath(), $filename);
            $data['image'] = $filename;
        }

        Blog::create($data);
        $this->clearHomeCache();
        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog created');
    }

    public function show(Blog $blog)
    {
        return view('admin.dashboard.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.dashboard.blogs.edit', compact('blog'));
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            @unlink(Blog::diskPath() . $blog->image);

            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(Blog::diskPath(), $filename);
            $data['image'] = $filename;
        }

        $blog->update($data);
        $this->clearHomeCache();
        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog updated');
    }
    public function updateStatus($id)
    {
        $blog = Blog::find($id);
        if ($blog->status < 1) {
            $blog->status = 1;
        } else {
            $blog->status = 0;
        }
        $blog->save();
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();
    }
    public function updateFeature($id)
    {
        $blog = Blog::find($id);
        if ($blog->feature < 1) {
            $blog->feature = 1;
        } else {
            $blog->feature = 0;
        }
        $blog->save();
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.featured_changed_sucessfully'));
        return redirect()->back();
    }

    public function destroy(Blog $blog)
    {
        $file = Blog::diskPath() . $blog->image;
        if ($blog->image && file_exists($file)) {
            @unlink($file);
        }
     $blog->delete();
        $this->clearHomeCache();
        return back()->with('success', 'Blog deleted');
    }
}

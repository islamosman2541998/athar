<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutRequest;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
 
    public function edit()
    {
   
        $about = About::with('translations')->first();

     
        if (!$about) {
            $about = About::create([
                'image' => null,
                'image_background' => null,
                'ceo_image' => null,
                'status' => true,
                'sort' => 0,
                'created_by' => Auth::id(),
            ]);
        }
        $languages = config('translatable.locales', ['en']);
        return view('admin.dashboard.about.single', compact('about', 'languages'));
    }


    public function update(AboutRequest $request)
    {
        $about = About::first();
        if (!$about) {
            $about = About::create([
                'status' => true,
                'sort' => 0,
                'created_by' => Auth::id(),
            ]);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($about->image) Storage::disk('public')->delete($about->image);
            $about->image = $request->file('image')->store('attachments/abouts', 'public');
        }

        if ($request->hasFile('image_background')) {
            if ($about->image_background) Storage::disk('public')->delete($about->image_background);
            $about->image_background = $request->file('image_background')->store('attachments/abouts', 'public');
        }
        if ($request->hasFile('ceo_image')) {
            if ($about->ceo_image) Storage::disk('public')->delete($about->ceo_image);
            $about->ceo_image = $request->file('ceo_image')->store('attachments/abouts', 'public');
        }

        $about->status = isset($data['status']) ? (bool)$data['status'] : $about->status;
        $about->sort = $data['sort'] ?? $about->sort;
        $about->updated_by = Auth::id();
        $about->save();

        $locales = config('translatable.locales', ['en']);
        foreach ($locales as $locale) {
            $trans = $request->input($locale, []);
            $about->translateOrNew($locale)->title = $trans['title'] ?? null;
            $about->translateOrNew($locale)->subtitle = $trans['subtitle'] ?? null;
            $about->translateOrNew($locale)->description = $trans['description'] ?? null;
            $about->translateOrNew($locale)->sub_description = $trans['sub_description'] ?? null;

            $about->translateOrNew($locale)->our_story_title = $trans['our_story_title'] ?? null;
            $about->translateOrNew($locale)->our_story_description = $trans['our_story_description'] ?? null;

            $about->translateOrNew($locale)->ceo_title = $trans['ceo_title'] ?? null;
            $about->translateOrNew($locale)->ceo_description = $trans['ceo_description'] ?? null;

            $about->translateOrNew($locale)->vision = $trans['vision'] ?? null;
            $about->translateOrNew($locale)->mission = $trans['mission'] ?? null;
            $about->translateOrNew($locale)->at_a_glance = $trans['at_a_glance'] ?? null;

        }
        $about->save();
        $this->clearHomeCache();

        session()->flash('success', __('About updated successfully'));
        return redirect()->route('admin.about.edit');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = FaqCategory::query()->with('translations')->orderBy('sort', 'ASC');

        // search by translated title
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $q->whereHas('translations', function ($t) use ($search) {
                $t->where('locale', app()->getLocale())
                  ->where('title', 'LIKE', $search);
            });
        }

        if ($request->filled('status')) {
            $q->where('status', (int) $request->status);
        }

        $categories = $q->paginate(20);

        return view('admin.dashboard.faq_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = config('translatable.locales', ['en']);
        return view('admin.dashboard.faq_categories.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // basic validation including per-locale title
        $rules = [
            'sort' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["{$locale}.title"] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        $category = FaqCategory::create([
            'status' => isset($validated['status']) ? (bool)$validated['status'] : true,
            'sort' => $validated['sort'] ?? 0,
            'created_by' => Auth::id(),
        ]);

        // save translations
        foreach (config('translatable.locales') as $locale) {
            $trans = $validated[$locale] ?? [];
            $title = $trans['title'] ?? null;
            if ($title) {
                $category->translateOrNew($locale)->title = $title;
            }
        }
        $category->save();

        session()->flash('success', __('Faq category created successfully'));
        return redirect()->route('admin.faq-categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FaqCategory $faqCategory)
    {
        return view('admin.dashboard.faq_categories.show', ['category' => $faqCategory]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaqCategory $faqCategory)
    {
        $languages = config('translatable.locales', ['en']);
        return view('admin.dashboard.faq_categories.edit', compact('faqCategory', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FaqCategory $faqCategory)
    {
        // validation
        $rules = [
            'sort' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["{$locale}.title"] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        $faqCategory->status = isset($validated['status']) ? (bool)$validated['status'] : $faqCategory->status;
        $faqCategory->sort = $validated['sort'] ?? $faqCategory->sort;
        $faqCategory->updated_by = Auth::id();
        $faqCategory->save();

        // update translations
        foreach (config('translatable.locales') as $locale) {
            $trans = $validated[$locale] ?? [];
            if (!empty($trans['title'])) {
                $faqCategory->translateOrNew($locale)->title = $trans['title'];
            }
        }
        $faqCategory->save();

        session()->flash('success', __('Faq category updated successfully'));
        return redirect()->route('admin.faq-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqCategory $faqCategory)
    {
        $faqCategory->delete();
        session()->flash('success', __('Faq category deleted successfully'));
        return redirect()->route('admin.faq-categories.index');
    }

    /**
     * Toggle status (active/inactive)
     */
    public function toggleStatus($id)
    {
        $category = FaqCategory::findOrFail($id);
        $category->status = $category->status ? 0 : 1;
        $category->save();

        session()->flash('success', __('Faq category status changed successfully'));
        return redirect()->back();
    }
}

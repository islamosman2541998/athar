<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filter;
use Illuminate\Support\Str;
use App\Models\Product;  
use App\Models\ProductTranslation; 
use App\Traits\TranslatableHandler;
class FilterController extends Controller
{
     use TranslatableHandler;
    /**
     */
    public function index()
    {
        $parents = Filter::withCount('products')
            ->with(['children' => function($q) {
                $q->withCount('products');
            }])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.dashboard.filters.index', compact('parents'));
    }

    /**
     */
    public function create()
    {
        $parents = Filter::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.dashboard.filters.create', compact('parents'));
    }

    /**
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'parent_id'     => 'nullable|exists:filters,id',
        'name.en'       => 'required|string|unique:filter_translations,name',
        'name.ar'       => 'required|string|unique:filter_translations,name',
    ]);

  $filter = Filter::create([
    'name'      => $data['name']['en'],
    'slug'      => Str::slug($data['name']['en']),
    'parent_id' => $data['parent_id'] ?? null,
]);

$this->saveModelTranslation($filter, [
    'en' => ['name' => $data['name']['en'], 'slug' => Str::slug($data['name']['en'])],
    'ar' => ['name' => $data['name']['ar'], 'slug' => Str::slug($data['name']['ar'])],
]);

    return redirect()->route('admin.filters.index')
                     ->with('success', 'Filter created successfully');
}
    /**
     */
    public function edit(Filter $filter)
    {
        $parents = Filter::whereNull('parent_id')
                         ->where('id', '!=', $filter->id)
                         ->orderBy('name')
                         ->get();

                         $translations = $filter->translations()->get()->keyBy('locale');

        return view('admin.dashboard.filters.edit', compact('filter', 'parents', 'translations'));
    }

    /**
     */
    public function update(Request $request, Filter $filter)
{
    $data = $request->validate([
        'parent_id'     => 'nullable|exists:filters,id|not_in:'.$filter->id,
        'name.en'       => 'required|string|unique:filter_translations,name,'.$filter->id.',filter_id,locale,en',
        'name.ar'       => 'required|string|unique:filter_translations,name,'.$filter->id.',filter_id,locale,ar',
    ]);

$filter->update([
    'name'      => $data['name']['en'],
    'slug'      => Str::slug($data['name']['en']),
    'parent_id' => $data['parent_id'] ?? null,
]);

$this->saveModelTranslation($filter, [
    'en' => ['name' => $data['name']['en'], 'slug' => Str::slug($data['name']['en'])],
    'ar' => ['name' => $data['name']['ar'], 'slug' => Str::slug($data['name']['ar'])],
]);

    return redirect()->route('admin.filters.index')
                     ->with('success', 'Filter updated successfully');
}

    /**
     */
    public function destroy(Filter $filter)
    {
        $filter->delete();
        return redirect()->route('admin.filters.index')
                         ->with('success', 'filter deleted successfully');
    }

    public function products(Filter $filter)
    {
        $products = Product::orderBy('id')->get();

        $attached = $filter->products()->pluck('products.id')->toArray();

        return view('admin.dashboard.filters.products', compact('filter','products','attached'));
    }

    public function updateProducts(Request $request, Filter $filter)
    {
        $data = $request->validate([
            'products'   => 'nullable|array',
            'products.*' => 'integer|exists:products,id',
        ]);

        $filter->products()->sync($data['products'] ?? []);

        return redirect()
            ->route('admin.filters.index')
            ->with('success', ' filter products updated successfully');
    }
}
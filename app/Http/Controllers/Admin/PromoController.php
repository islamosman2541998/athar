<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\ProductCategory;

class PromoController extends Controller
{
    /**
     */
    public function index(Request $request)
    {
        $items = PromoCode::with('transNow')->get();
        return view('admin.dashboard.promocodes.index', compact('items'));
    }

    /**
     */
    public function create()
    {

        $categories = ProductCategory::all();
        $selectedIds = [];
        return view('admin.dashboard.promocodes.create', compact('categories'));
    }

    /**
     */
    public function store(Request $request)
    {
        $rules = [
            'code'       => 'required|string|max:50|unique:promo_codes,code',
            'type'       => ['required', Rule::in(['percent', 'fixed'])],
            'value'      => 'required|numeric|min:0',
            'start_at'   => 'required|date',
            'end_at'     => 'required|date|after_or_equal:start_at',
            'status'     => 'nullable|boolean',
            'uses_left'  => 'required|integer|min:1',

            'title.ar'   => 'required|string|max:255',
            'title.en'   => 'required|string|max:255',
            'categories'     => 'nullable|array',
            'categories.*'   => 'exists:product_categories,id',
        ];

        $messages = [
            'code.required'          => 'The code field is required.',
            'code.unique'            => 'This coupon code has already been used.',
            'type.in'                => 'The discount type must be either "percent" or "fixed".',
            'value.min'              => 'The discount value cannot be negative.',
            'end_at.after_or_equal'  => 'The end date must be equal to or after the start date.',
            'uses_left.required'     => 'The remaining uses field is required.',
            'uses_left.integer'      => 'The remaining uses field must be an integer.',
            'uses_left.min'          => 'The remaining uses must be at least 1.',
            'title.ar.required'      => 'The title in Arabic is required.',
            'title.en.required'      => 'The title in English is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $promo = PromoCode::create([
            'code'       => $request->input('code'),
            'type'       => $request->input('type'),
            'value'      => $request->input('value'),
            'start_at'   => $request->input('start_at'),
            'end_at'     => $request->input('end_at'),
            'status'     => $request->input('status') ? 1 : 0,
            'uses_left'  => $request->input('uses_left'),
        ]);

        foreach (['ar', 'en'] as $locale) {
            $promo->translateOrNew($locale)->title = $request->input("title.$locale");
        }
        $promo->save();
        $promo->categories()->sync($request->input('categories', []));

        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect()->route('admin.promocodes.index');
    }

    /**
     */
    public function edit($id)
    {
        $promo = PromoCode::with('trans')->findOrFail($id);
    $categories  = ProductCategory::active()->with('transNow')->get();
    // dd($categories->first());

        $selectedIds = $promo->categories->pluck('id')->toArray();
        return view(
            'admin.dashboard.promocodes.edit',
            compact('promo', 'categories', 'selectedIds')
        );
    }

    /**
     */
    public function update(Request $request, $id)
    {
        $promo = PromoCode::findOrFail($id);

        $rules = [
            'code'       => ['required', 'string', 'max:50', Rule::unique('promo_codes', 'code')->ignore($promo->id)],
            'type'       => ['required', Rule::in(['percent', 'fixed'])],
            'value'      => 'required|numeric|min:0',
            'start_at'   => 'required|date',
            'end_at'     => 'required|date|after_or_equal:start_at',
            'status'     => 'nullable|boolean',
            'uses_left'  => 'required|integer|min:1',

            'title.ar'   => 'required|string|max:255',
            'title.en'   => 'required|string|max:255',
            'categories'     => 'nullable|array',
            'categories.*'   => 'exists:product_categories,id',
        ];

        $messages = [
            'code.required'          => 'The code field is required.',
            'code.unique'            => 'This coupon code has already been used.',
            'type.in'                => 'The discount type must be either "percent" or "fixed".',
            'value.min'              => 'The discount value cannot be negative.',
            'end_at.after_or_equal'  => 'The end date must be equal to or after the start date.',
            'uses_left.required'     => 'The remaining uses field is required.',
            'uses_left.integer'      => 'The remaining uses field must be an integer.',
            'uses_left.min'          => 'The remaining uses must be at least 1.',
            'title.ar.required'      => 'The title in Arabic is required.',
            'title.en.required'      => 'The title in English is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $promo->update([
            'code'       => $request->input('code'),
            'type'       => $request->input('type'),
            'value'      => $request->input('value'),
            'start_at'   => $request->input('start_at'),
            'end_at'     => $request->input('end_at'),
            'status'     => $request->input(key: 'status') ? 1 : 0,
            'uses_left'  => $request->input('uses_left'),
        ]);

        foreach (['ar', 'en'] as $locale) {
            $promo->translateOrNew($locale)->title = $request->input("title.$locale");
        }
        $promo->save();
        $promo->categories()->sync($request->input('categories', []));

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->route('admin.promocodes.index');
    }

    /**
     */
    public function destroy($id)
    {
        $promo = PromoCode::findOrFail($id);
        $promo->categories()->detach();

        $promo->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->route('admin.promocodes.index');
    }

    /**
     */
    public function updateStatus($id)
    {
        $promo = PromoCode::findOrFail($id);
        $promo->status = ! $promo->status;
        $promo->save();
        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();
    }
}

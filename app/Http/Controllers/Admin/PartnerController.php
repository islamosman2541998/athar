<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function index( Request $request)
    {
         $query = Partner::query()->with('translations')->orderBy('id', 'ASC');
          if($request->status  != ''){
            $query->where('status', $request->status );
        }
        if ($request->title  != '') {  
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        $partners = $query->paginate($this->pagination_count);
        return view('admin.dashboard.partners.index', compact('partners'));
    }

    public function create()
    {
        $languages = config('translatable.locales', ['en']);
        return view('admin.dashboard.partners.create', compact('languages'));
    }

    public function store(PartnerRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments/partners', $filename, 'public');
            $data['image'] = $filename;
        }

        $partner = Partner::create([
            'image' => $data['image'] ?? null,
            'url' => $data['url'] ?? null,
            'status' => $data['status'] ?? true,
            'sort' => $data['sort'] ?? 0,
            'created_by' => Auth::id(),
        ]);

        foreach (config('translatable.locales') as $locale) {
            $trans = $request->input($locale, []);
            if (!empty($trans)) {
                $partner->translateOrNew($locale)->title = $trans['title'] ?? null;
            }
        }
        $partner->save();
        $this->clearHomeCache();

        session()->flash('success', __('partners.created_success'));
        return redirect()->route('admin.partners.index');
    }

    public function edit(Partner $partner)
    {
        $languages = config('translatable.locales', ['en']);
        return view('admin.dashboard.partners.edit', compact('partner','languages'));
    }

    public function update(PartnerRequest $request, Partner $partner)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($partner->image) Storage::disk('public')->delete('attachments/partners/'.$partner->image);
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments/partners', $filename, 'public');
            $partner->image = $filename;
        }

        $partner->url = $data['url'] ?? $partner->url;
        $partner->status = $data['status'] ?? $partner->status;
        $partner->sort = $data['sort'] ?? $partner->sort;
        $partner->updated_by = Auth::id();
        $partner->save();

        foreach (config('translatable.locales') as $locale) {
            $trans = $request->input($locale, []);
            $partner->translateOrNew($locale)->title = $trans['title'] ?? $partner->translate($locale)->title ?? null;
        }
        $partner->save();
        $this->clearHomeCache();

        session()->flash('success', __('partners.updated_success'));
        return redirect()->route('admin.partners.index');
    }

    public function show(Partner $partner)
    {
        return view('admin.dashboard.partners.show', compact('partner'));
    }

    public function destroy(Partner $partner)
    {
        if ($partner->image) Storage::disk('public')->delete('attachments/partners/'.$partner->image);
        $partner->delete();
        $this->clearHomeCache();
        session()->flash('success', __('partners.deleted_success'));
        return redirect()->route('admin.partners.index');
    }

    public function toggleStatus(Partner $partner)
    {
        $partner->status = !$partner->status;
        $partner->save();
        $this->clearHomeCache();
        return redirect()->back();
    }
}

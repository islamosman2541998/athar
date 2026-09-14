<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $q = Faq::query()->with('category','translations')->orderBy('sort','ASC')->orderBy('id','DESC');

        // search by question in current locale (optional)
        if ($request->filled('search')) {
            $search = '%'.$request->search.'%';
            $q->whereHas('translations', function($t) use ($search){
                $t->where('locale', app()->getLocale())->where('question', 'LIKE', $search);
            });
        }

        $faqs = $q->paginate(20);
        $categories = FaqCategory::with('translations')->orderBy('sort')->get();
        return view('admin.dashboard.faqs.index', compact('faqs','categories'));
    }

    public function create()
    {
        $languages = config('translatable.locales');
        $categoriesList  = FaqCategory::active()->get() ?? FaqCategory::all();
        return view('admin.dashboard.faqs.create', compact('languages','categoriesList'));
    }

    public function store(FaqRequest $request)
    {
        $data = $request->validated();

        $faq = Faq::create([
            'faq_category_id' => $data['faq_category_id'] ?? null,
            'sort' => $data['sort'] ?? 0,
            'status' => $data['status'] ?? true,
            'created_by' => Auth::id(),
        ]);

        foreach (config('translatable.locales') as $locale) {
            $trans = $request->input($locale, []);
            if (!empty($trans)) {
                $faq->translateOrNew($locale)->question = $trans['question'] ?? null;
                $faq->translateOrNew($locale)->answer = $trans['answer'] ?? null;
            }
        }
        $faq->save();
        $this->clearHomeCache();

        session()->flash('success','FAQ created');
        return redirect()->route('admin.faqs.index');
    }

    public function edit(Faq $faq)
    {
        $languages = config('translatable.locales');
        $categories = FaqCategory::all();
        return view('admin.dashboard.faqs.edit', compact('faq','languages','categories'));
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        $data = $request->validated();
        $faq->faq_category_id = $data['faq_category_id'] ?? $faq->faq_category_id;
        $faq->sort = $data['sort'] ?? $faq->sort;
        $faq->status = $data['status'] ?? $faq->status;
        $faq->updated_by = Auth::id();
        $faq->save();

        foreach (config('translatable.locales') as $locale) {
            $trans = $request->input($locale, []);
            $faq->translateOrNew($locale)->question = $trans['question'] ?? $faq->translate($locale)->question ?? null;
            $faq->translateOrNew($locale)->answer = $trans['answer'] ?? $faq->translate($locale)->answer ?? null;
        }
        $faq->save();
        $this->clearHomeCache();

        session()->flash('success','FAQ updated');
        return redirect()->back();
    }
public function show($id)
{
    $faq = Faq::with(['translations', 'category.translations'])->findOrFail($id);

    $languages = config('translatable.locales', ['en']);

    return view('admin.dashboard.faqs.show', compact('faq','languages'));
}
    public function destroy(Faq $faq)
    {
        $faq->delete();
        $this->clearHomeCache();
        session()->flash('success','FAQ deleted');
        return redirect()->route('admin.faqs.index');
    }

    public function toggleStatus(Faq $faq)
    {
        $faq->status = !$faq->status;
        $faq->save();
        $this->clearHomeCache();
        return redirect()->back();
    }
}

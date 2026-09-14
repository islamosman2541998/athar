<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Livewire\Site\PortfolioGallery;
use Illuminate\Http\Request;
use App\Models\Portfolios;
use App\Models\PortfolioTags;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $tags = PortfolioTags::active()->with('transNow')->orderBy('sort')->get();
        $activeTag = $tags->firstWhere('id', (int) $request->query('tag'))?->id;

        $portfolios = Portfolios::active()
            ->when($activeTag, fn ($query) => $query->where('tag_id', $activeTag))
            ->with(['transNow', 'tag.transNow'])
            ->orderByRaw('sort IS NULL, sort ASC')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('site.pages.portfolio.index', compact('tags', 'portfolios', 'activeTag'));
    }

    public function show(string $slug)
    {
        $portfolio = Portfolios::active()
            ->where(function ($query) use ($slug) {
                $query->whereHas('trans', fn ($translation) => $translation->where('slug', $slug));
                if (ctype_digit($slug)) {
                    $query->orWhereKey((int) $slug);
                }
            })
            ->with(['transNow', 'tag.transNow', 'galleryMedia' => fn ($query) => $query->where('gallery_images.status', 1)])
            ->firstOrFail();

        $related = Portfolios::active()
            ->where('id', '!=', $portfolio->id)
            ->where('tag_id', $portfolio->tag_id)
            ->with(['transNow', 'tag.transNow'])
            ->orderByRaw('sort IS NULL, sort ASC')
            ->take(3)
            ->get();

        return view('site.pages.portfolio.show', compact('portfolio', 'related'));
    }
}

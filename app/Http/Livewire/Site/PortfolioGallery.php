<?php

namespace App\Http\Livewire\Site;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Portfolios;
use App\Models\PortfolioTags;

class PortfolioGallery extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $activeTag = 'all';
    public $openPortfolioId = null;
    public $perPage = 12;

    public function mount()
    {
        $this->activeTag = request()->get('tag', 'all');
        $this->openPortfolioId = request()->get('item');
    }

    public function filterByTag($tagSlug)
    {
        $this->activeTag = $tagSlug;
        $this->resetPage();
    }

    public function render()
    {
        $tags = PortfolioTags::active()
            ->with(['trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }])
            ->orderBy('sort')
            ->get();

        $query = Portfolios::active()
            ->with([
                'tag.transNow',
                'transNow',
                'galleryGroup.images' => function ($q) {
                    $q->orderByRaw('sort IS NULL, sort ASC')
                        ->orderBy('id', 'ASC');
                },
            ]);
        if ($this->activeTag !== 'all') {
            $tag = PortfolioTags::whereHas('trans', function ($q) {
                $q->where('slug', $this->activeTag)
                    ->where('locale', app()->getLocale());
            })->first();

            if ($tag) {
                $query->where('tag_id', $tag->id);
            }

            $query->orderByRaw('sort IS NULL, sort ASC')
                ->orderBy('id', 'DESC');
        } else {
            $query->inRandomOrder();
        }

        $portfolios = $query->paginate($this->perPage);

        $openItem = null;

        if ($this->openPortfolioId) {
            $openItem = Portfolios::active()
                ->with([
                    'tag.transNow',
                    'transNow',
                    'galleryGroup.images' => function ($q) {
                        $q->orderByRaw('sort IS NULL, sort ASC')
                            ->orderBy('id', 'ASC');
                    },
                ])
                ->find($this->openPortfolioId);
        }

        return view('livewire.site.portfolio-gallery', [
            'tags'       => $tags,
            'portfolios' => $portfolios,
            'openItem'   => $openItem,
        ]);
    }
}

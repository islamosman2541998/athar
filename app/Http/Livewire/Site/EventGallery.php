<?php

namespace App\Http\Livewire\Site;

use App\Models\Gallery;
use App\Models\GalleryGroup;
use App\Models\Occasion;
use App\Models\ServiceCategory;
use App\Models\Services;
use Livewire\Component;

class EventGallery extends Component
{
    public $occasions;
    public $images;

    public function mount()
    {
        $this->occasions = Occasion::with([
            'galleryGroup.transNow',
            'translations' => fn($q) => $q->where('locale', app()->getLocale())
        ])->event()->active()->get();
        $gallerygroupIds = $this->occasions->pluck('galleryGroup')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->toArray();

        $imges = Gallery::whereIn('gallery_group_id', $gallerygroupIds)
            ->limit(6)
            ->pluck('image')
            ->toArray();

        $stringToAdd = "/attachments/gallery/occasions/";
        $this->images = array_map(function ($value) use ($stringToAdd) {
            return asset($stringToAdd . $value);
        }, $imges);
    }


    public $selectedOccasionId = null;

    public function updateEvents($id)
    {
        $this->selectedOccasionId = $id;
        $occasion = $this->occasions->firstWhere('id', $id);

        if ($occasion && $occasion->galleryGroup->isNotEmpty()) {
            $gallerygroupIds = $occasion->galleryGroup->pluck('id')->toArray();
            $imges = Gallery::whereIn('gallery_group_id', $gallerygroupIds)
                ->pluck('image')
                ->toArray();

            $stringToAdd = "/attachments/gallery/occasions/";
            $this->images = array_map(fn($value) => asset($stringToAdd . $value), $imges);
        } else {
            $this->images = [];
        }
    }



    public function resetGallery()
    {
        $this->occasions = Occasion::with('galleryGroup')->event()->active()->get();

        $gallerygroupIds = $this->occasions->pluck('galleryGroup')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->toArray();

        $imges = Gallery::whereIn('gallery_group_id', $gallerygroupIds)
            ->limit(6)
            ->pluck('image')
            ->toArray();

        $stringToAdd = "/attachments/gallery/occasions/";
        $this->images = array_map(function ($value) use ($stringToAdd) {
            return asset($stringToAdd . $value);
        }, $imges);
    }

    public function render()
    {


        return view('livewire.site.event-gallery', [
            'occasions' => $this->occasions,
        ]);
    }
}

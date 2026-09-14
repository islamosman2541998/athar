<?php

namespace App\Http\Livewire\Site;

use Livewire\Component;
use App\Models\GalleryGroup;

class Gallery extends Component
{
    public ?int $galleryGroupId = null;
    public array $images = []; // each: ['url'=>'...', 'alt'=>'...']
    public int $activeIndex = 0;

    /**
     * Accept model, id, or null.
     */
    public function mount($galleryGroup = null)
    {
        // if user passed model instance
        if ($galleryGroup instanceof GalleryGroup) {
            $group = $galleryGroup->loadMissing('images');
        }
        // if user passed id
        elseif (is_numeric($galleryGroup) && $galleryGroup) {
            $group = GalleryGroup::with('images')->find($galleryGroup);
        } else {
            $group = null;
        }

        if (! $group || $group->images->isEmpty()) {
            $this->images = [];
            return;
        }

        $this->galleryGroupId = $group->id;
        $this->images = $group->images->map(function($img) {
            // adjust this depending how your image model exposes path
            $url = method_exists($img, 'pathInView') ? $img->pathInView('products') : ($img->image ? asset('storage/' . ltrim($img->image, '/')) : asset('attachments/no_image/no_image.png'));
            $alt = $img->alt ?? $img->title ?? '';
            return ['url' => $url, 'alt' => $alt];
        })->toArray();
    }

    public function setActiveImage(int $index)
    {
        if (isset($this->images[$index])) {
            $this->activeIndex = $index;
        }
    }

    public function render()
    {
        return view('livewire.site.gallery');
    }
}

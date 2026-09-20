<?php

namespace App\Http\Requests\Admin;

use Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PortfolioRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        $attr = [];
        foreach (config('translatable.locales') as $locale) {
            $attr += [$locale . '.title' => 'Title ' . Locale::getDisplayName($locale)];
            $attr += [$locale . '.slug' => 'Slug ' . Locale::getDisplayName($locale)];
            $attr += [$locale . '.description' => 'Description ' . Locale::getDisplayName($locale)];
            $attr += [$locale . '.content' => 'Content ' . Locale::getDisplayName($locale)];
            $attr += [$locale . '.meta_title' => 'Meta title ' . Locale::getDisplayName($locale)];
            $attr += [$locale . '.meta_description' => 'Meta description ' . Locale::getDisplayName($locale)];
            $attr += [$locale . '.meta_key' => 'Meta key ' . Locale::getDisplayName($locale)];
        }
        $attr += ['tag_id' => 'Tag'];
        $attr += ['image' => 'Image'];
        $attr += ['video_url' => 'YouTube link'];
        $attr += ['sort' => 'Sort'];
        $attr += ['feature' => 'Fearure'];
        $attr += ['news_ticker' => 'News Ticker'];
        $attr += ['status' => 'Status'];
        return $attr;
    }

    public function rules()
    {
        $req = [];
        $portfolio = $this->route('portfolio');
        $selectedType = $this->input('type');
        // A YouTube link replaces the uploaded video file.
        $hasVideoUrl = $selectedType === 'video' && filled($this->input('video_url'));
        $mediaRequired = !$hasVideoUrl && (
            $this->isMethod('POST')
            || !$portfolio?->image
            || ($portfolio && $portfolio->type !== $selectedType)
        );
        $mediaMimes = match ($selectedType) {
            'image' => 'jpg,jpeg,png,gif,webp,svg',
            'video' => 'mp4,mov,avi,mkv,webm',
            'pdf' => 'pdf',
            default => 'jpg,jpeg,png,gif,webp,svg,mp4,mov,avi,mkv,webm,pdf',
        };
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.description' => 'nullable'];
            $req += [$locale . '.content' => 'nullable'];

            $req += [$locale . '.meta_title' => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key' => 'nullable'];
        }
        $req += ['image' => [Rule::requiredIf($mediaRequired), 'nullable', 'file', 'mimes:' . $mediaMimes, 'max:90000480']];
        $req += ['video_url' => ['nullable', 'url', 'regex:~(youtube\.com|youtu\.be)~i']];
        $req += ['tag_id' => 'required'];
        $req += ['link' => 'nullable'];
        $req += ['status' => 'nullable'];
        $req += ['type' => 'required|in:image,video,pdf'];
        $req += ['sort' => 'nullable'];
        $req += ['feature' => 'nullable'];
        $req += ['updated_by' => 'nullable'];
        $req += ['created_by' => 'nullable'];
        $req += ['gallery' => 'nullable|array'];
        $req += ['gallery.type' => 'nullable'];
        $req += ['gallery.ar.title' => 'nullable'];
        $req += ['gallery.en.title' => 'nullable'];

        $req += ['gallery_image' => 'nullable|array'];
        $req += ['gallery_image.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,svg,mp4,mov,avi,mkv,pdf|max:90000480'];

        $req += ['gallery_sort' => 'nullable|array'];
        $req += ['gallery_sort.*' => 'nullable|integer|min:0'];
        $req += ['old_gallery_sort' => 'nullable|array'];
        $req += ['old_gallery_sort.*' => 'nullable|integer|min:0'];
        $req += ['gallery_feature' => 'nullable|array'];

        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();
        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['slug'] = slug($data[$locale]['title']);
        }
        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;

        if (request()->isMethod('PUT')) {
            $data['updated_by']  = @auth()->user()->id;
        } else {
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}

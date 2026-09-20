<?php

namespace App\Http\Controllers\Site;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\News;
use App\Models\About;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\Portfolios;
use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use App\Models\AboutTranslation;
use App\Http\Controllers\Controller;
use App\Models\HomeSettingPage;
use App\Models\Slider;

class HomeController extends Controller
{
    public function home()
    {
        $current_lang = app()->getLocale();
        $homeSections = HomeSettingPage::with('transNow')->active()->get()->keyBy('title_section');

        $about_us = About::with('transNow')->first();
        if (!$about_us) {
            $about_us = new About();
            $about_us->transNow = new AboutTranslation();
        }

        $data = [
            'about_us' => $about_us,
            'sliders' => Slider::with('transNow')->active()->orderByRaw('sort IS NULL, sort ASC')->get(),
            'blogs' => Blog::with(['translations', 'transNow'])->active()->orderByRaw('sort IS NULL, sort ASC')->latest('id')->get(),
            'partners' => Partner::with('translations')->where('status', 1)->orderBy('sort')->get()->filter->hasImage()->values(),
            'news' => News::with('translations')->where('status', 1)->take(3)->get(),
            'faq_questions' => Faq::with('translations')->where('status', 1)->get(),
            'products' => Product::with('transNow')->feature()->active()->orderBy('sort')->take(3)->get(),
            'categoryProducts' => ProductCategory::with('transNow')->feature()->active()->orderBy('sort')->get(),
            'servicesCategories' => ServiceCategory::with([
                'transNow',
                'services' => fn ($query) => $query->active()->with('transNow')->orderBy('sort'),
            ])->feature()->active()->orderBy('sort')->take(4)->get(),
            'statistics' => Statistic::with('transNow')->feature()->active()->orderBy('sort')->get(),
            'homeSections' => $homeSections,
            'whyFeatures' => collect(range(1, 4))->map(function ($index) use ($homeSections) {
                return optional($homeSections->get('why-feature-' . $index))->transNow;
            })->filter(),
            'processSteps' => collect(range(1, 4))->map(function ($index) use ($homeSections) {
                return optional($homeSections->get('process-step-' . $index))->transNow;
            })->filter(),
        ];

        $page_name = 'home';

        $portfolios = Portfolios::with(['transNow', 'tag.transNow'])
            ->active()
            ->feature()
            ->orderByRaw('sort IS NULL, sort ASC')
            ->take(9)
            ->get()
            ->values();

        // Preload the image the hero paints first, so the browser fetches it immediately.
        $firstSlider = $data['sliders']->first();
        $lcpImage = $firstSlider
            ? media_asset($firstSlider->pathInView())
            : media_asset('site/images/athar-hero.png');

        return view('site.pages.index', array_merge($data, [
            'lcpImage'     => $lcpImage,
            'current_lang' => $current_lang,
            'page_name'    => $page_name,
            'portfolios'   => $portfolios,
        ]));
    }
}

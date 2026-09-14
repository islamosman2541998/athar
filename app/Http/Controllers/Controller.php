<?php

namespace App\Http\Controllers;

use App\Traits\Api\ApiResponseTrait;
use App\Traits\FileHandler;
 use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FileHandler , ApiResponseTrait ;

    protected $pagination_count = 50;
    protected $site_pagination_count = 9;

    /**
     * The home page caches its data (about, blogs, partners, news, faq,
     * products, product categories, service categories, statistics,
     * services section) forever. Call this after any create/update/delete
     * on those models so the change shows up on the home page immediately.
     */
    protected function clearHomeCache()
    {
        foreach (config('app.locales') as $locale) {
            Cache::forget('home_page_data_' . $locale);
        }
    }

}

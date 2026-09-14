<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Setting;
use App\Models\Settings;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use App\Models\SettingsValues;
use App\Http\Controllers\Controller;
use App\Services\PayUService\Exception;
use App\Models\ProductCategory;
use App\Models\PromoCode;
use App\Support\FontOptions;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        $items = Settings::get();
        return view('admin.dashboard.settings.index', compact('items'));
    }

    public function form($key)
    {
        $settingMain = Settings::query()->where('key', $key)->first();
        if (!$settingMain) {
            $settingMain = Settings::create(['key' => $key]);
        }
        $settings = $settingMain->values;



        switch ($key) {
            case 'site_setting':
                return view('admin.dashboard.settings.form', compact('settings', 'settingMain'));

            case 'meta_setting':
                $settings = $settingMain->values->pluck('value', 'key');
                return view('admin.dashboard.settings.partials.meta', compact('settings', 'settingMain'));

            case 'coupon_setting':
                $allCoupons = PromoCode::with('transNow')->orderBy('code')->get();
                $settings = $settingMain->values->pluck('value', 'key');
                return view('admin.dashboard.settings.partials.coupon', compact('settings', 'settingMain', 'allCoupons'));

            case 'upper_notify_setting':
                $settings = $settingMain->values->pluck('value', 'key');
                return view('admin.dashboard.settings.partials.upper_notify', compact('settings', 'settingMain'));

            case 'info_setting':
                return view('admin.dashboard.settings.partials.info', compact('settings', 'settingMain'));

            case 'view_setting':
                $products = Product::all();
                $categories = ProductCategory::get();
                return view('admin.dashboard.settings.partials.view', compact('settings', 'settingMain', 'products', 'categories'));
            case 'home_setting':
                $settings = $settingMain->values->pluck('value', 'key');

                return view('admin.dashboard.settings.partials.home', compact('settings', 'settingMain'));

            case 'font_setting':
                $settings = $settingMain->values->pluck('value', 'key');
                $arabicFonts = FontOptions::ARABIC;
                $englishFonts = FontOptions::ENGLISH;

                return view('admin.dashboard.settings.partials.fonts', compact('settings', 'settingMain', 'arabicFonts', 'englishFonts'));


            default:

                return view('admin.dashboard.settings.form', compact('settings', 'settingMain'));
        }
    }

    public function form_update(Request $request, $id)
    {
        $setting = Settings::find($id);
        if (!$setting) {
            session()->flash('error', 'Setting not found.');
            return redirect()->back();
        }

        $settings = $setting->values;


        if ($settings === null) {
            session()->flash('error', 'No values found for this setting.');
            return redirect()->back();
        }

        foreach ($request->except(['_token']) as $key => $item) {
            if ($request->hasFile($key)) {
                $filename = $this->upload_file($request->file($key), 'settings');
                $setting->values()->updateOrCreate(
                    ['key' => $key],
                    ['value' => $filename, 'setting_id' => $setting->id]
                );
            } else {
                $setting->values()->updateOrCreate(
                    ['key' => $key],
                    ['value' => $item, 'setting_id' => $setting->id]
                );
            }
        }

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    public function form_update_custom(Request $request, $key)
    {

        $settingMain = Settings::query()->where('key', $key)->first();
        if (!$settingMain) {
            $settingMain = Settings::create(['key' => $key]);
        }
        $settings = $settingMain->values;

        if ($key == 'font_setting') {
            $request->validate([
                'font_ar' => ['required', Rule::in(array_keys(FontOptions::ARABIC))],
                'font_en' => ['required', Rule::in(array_keys(FontOptions::ENGLISH))],
            ]);
        }

        if ($key == 'view_setting') {
            $mostSelling = $request->input('most_selling', []);
            $bestOffer = $request->input('best_offer', []);
            $featuredCategories = $request->input('feature', []);


            Product::query()->update(['most_selling' => 0]);
            if ($mostSelling) {
                Product::whereIn('id', array_keys($mostSelling))->update(['most_selling' => 1]);
            }

            Product::query()->update(['best_offer' => 0]);
            if ($bestOffer) {
                Product::whereIn('id', array_keys($bestOffer))->update(['best_offer' => 1]);
            }
        }

        $values = $request->except('_token', 'most_selling', 'best_offer', 'feature');
        if ($values) {
            foreach ($values as $key => $value) {
                $set = $settings->where('key', $key)->first();
                if ($set == null) {
                    SettingsValues::create(['key' => $key, 'value' => $value, 'setting_id' => $settingMain->id]);
                } else {
                    $set->update(['value' => $value]);
                }
            }
        }



        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }
}

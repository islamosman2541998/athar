<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



trait TranslatableHandler
{
/**
 * Translates the given 
 */
    public function saveModelTranslation(Model $model, $data) : void
{
    $languageKeys = collect(LaravelLocalization::getSupportedLocales())->keys()->toArray();

    $translateData = array_filter($data, function($v) use ($languageKeys) {
        return in_array($v, $languageKeys);
    }, ARRAY_FILTER_USE_KEY);

    $foreignKey = method_exists($model, 'getTranslationForeignKeyName')
        ? $model->getTranslationForeignKeyName()
        : $model->translationForeignKey;

    foreach ($translateData as $locale => $transData) {
        $transData['locale'] = $locale;
        $transData[$foreignKey] = $model->id;

        $existing = $model->trans->firstWhere('locale', $locale);
        if ($existing) {
            $existing->update($transData);
        } else {
            $model->trans()->create($transData);
        }
    }
}


}
<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;

use App\Settings\SettingSingleton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CardController extends Controller
{
    public function show($id)
    {
        $currentLang = App::getLocale();
        $settings = SettingSingleton::getInstance();

        $card = [
            'title' => $settings->getInfo("section{$id}_title" . $currentLang),
            'description' => $settings->getInfo("section{$id}_description" . $currentLang),
            'image' => $settings->getInfo("section{$id}_image"),
        ];

        if (empty($card['title']) || empty($card['image'])) {
            abort(404);
        }

        return view('site.pages.card.show', compact('card'));
    }
}
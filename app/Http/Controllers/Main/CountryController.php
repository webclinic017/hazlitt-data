<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;
use App\Registry;
use App\Article;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
// use Laracasts\Utilities\JavaScript\JavaScriptFacade as Javascript;
// use Illuminate\Support\Arr;

class CountryController extends Controller
{
    use SEOToolsTrait;

    public function router(Request $request, Registry $entry, Country $country)
    {
        if (!$country->status) {
            app()->abort(404);
        }

        $country = Country::query()
            ->whereId($country->id)
            ->select('countries.*')
            ->with('registry')
            ->with('articles')
            ->first();            
            
        // $snippets = Arr::wrap($country->snippets->get(app()->getLocale()));
        //     foreach ($snippets as $key => $value) {
        //         $country->snippets->set(app()->getLocale() . '.' . $key, view(['template' => $value, 'secondsTemplateCacheExpires' => 0], ['entry' => $entry, 'country' => $country])->render());
        // }

        $this->seo()
            ->setTitle($entry->meta_title)
            ->setDescription($entry->meta_description)
            ->setCanonical(url()->current());
        $this->seo()
            ->metatags()
            ->setKeywords($entry->meta_keywords)
            ->addMeta('robots', $entry->meta_robots);
        $this->seo()
            ->opengraph()
            ->setUrl(url($entry->url));

        return view($entry->view)
            ->with('entry', $entry)
            ->with('country', $country);
    }
}

<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Commodity;
use App\Registry;
use App\Article;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

// use Laracasts\Utilities\JavaScript\JavaScriptFacade as Javascript;
// use Illuminate\Support\Arr;

class CommodityController extends Controller
{
    use SEOToolsTrait;

    public function router(Request $request, Registry $entry, Commodity $commodity)
    {
        if (!$commodity->status) {
            app()->abort(404);
        }

        $commodity = Commodity::query()
            ->whereId($commodity->id)
            ->select('commodities.*')
            ->with('registry')
            ->with([
                'articles' => function ($query) {
                    $query
                        ->select('articles.*')
                        ->where('topic', '=', 'supply')->take(33);
                        $query
                        ->select('articles.*')
                        ->where('topic', '=', 'supply')->take(33);                      
                }
            ])
            ->first();
            dd($commodity->articles);
            
        // $snippets = Arr::wrap($commodity->snippets->get(app()->getLocale()));
        //     foreach ($snippets as $key => $value) {
        //         $commodity->snippets->set(app()->getLocale() . '.' . $key, view(['template' => $value, 'secondsTemplateCacheExpires' => 0], ['entry' => $entry, 'commodity' => $commodity])->render());
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
            ->with('commodity', $commodity);
    }
}

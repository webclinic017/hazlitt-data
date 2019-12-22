<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Commodity;
use App\Registry;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as Javascript;

class CommodityController extends Controller
{
    public function router(Request $request, Registry $entry, Commodity $commodity)
    {
        if (! $commodity->status) {
            app()->abort(404);
        }

        $commodity = Commodity::query()
            ->whereId($commodity->id)
            ->select('commodities.*')
            ->with('registry')
			->first();
						
			// $commodity->snippets->set(app()->getLocale() . '.content', view(['template' => $commodity->snippets->get(app()->getLocale() . '.content'), 'secondsTemplateCacheExpires' => 0], ['entry' => $entry, 'commodity' => $commodity])->render());

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
            // ->addImage(array_get($commodity, 'web_image_url', cdn($commodity->getFirstMediaUrl('image-square'))));


        Javascript::put([
            'commodity'  => $commodity,
        ]);

        $request->session()->forget('order');

        return view($entry->view)
            ->with('entry', $entry)
            ->with('commodity', $commodity)
            ->with(
                'review_count',
                Feedback::query()
                    ->orWhere('commodity_id', '=', $commodity->id)
                    ->orWhere('base_id', '=', $commodity->base_id)
                    ->selectRaw('FORMAT(COUNT(id), 0) review_count')
                    ->value('review_count')
            )
            ->with(
                'reviews_recent',
                Feedback::query()
                    ->orWhere('commodity_id', '=', $commodity->id)
                    ->orWhere('base_id', '=', $commodity->base_id)
                    ->sorted()
                    ->take(3)
                    ->get()
            )
            ->with('reviews_rating', Feedback::query()
            ->orWhere('commodity_id', '=', $commodity->id)
            ->orWhere('base_id', '=', $commodity->base_id)
            ->sortedRating()
            ->take(3)
            ->get());
    }
}

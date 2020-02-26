<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
// use Goutte\Client;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Arr;
use App\Article;

class AsyncScraper implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //Collect sessions from users in the checkout process for abandoned cart emails. Session is deleted upon checkout.

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $_item;
    protected $_topic;

    public function __construct($item, $topic)
    {
        $this->_item = $item;
        $this->_topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        $item = $this->_item;
        $topic = $this->_topic;
        $query = strtolower(str_replace(' ', '+', $item->name)) . '+' . $topic;
        print 'https://news.google.com/search?q=' . $query;
        $promise = $client->requestAsync('GET', 'https://news.google.com/search?q=' . $query);
        $promise->then(function ($response) use ($item, $topic) {
            $body = $response->getBody()->getContents();

            $crawler = new Crawler($body);
            $crawler->filter('article')->each(function ($node, $ranking) use ($item, $topic) {
                if (!isset($node)) {
                    return;
                }
                if (
                $node->filter('article > h3 > a')->count() == 0 ||
                $node->filter('a.wEwyrc')->count() == 0 ||
                $node->filter('time')->count() == 0 ||
                $node->filter('article a')->count() == 0
            ) {
                    return;
                }
                        
                # Manually constructing article link from jslog attribute.
                $jslog = $node->filter('article')->attr('jslog');
                $jslog_split = explode(";", $jslog);
                        
                $url_stripped = explode(":", $jslog_split[1], 2);
                $article_url = $url_stripped[1];

                if (Article::where('url', '=', $article_url)->count() != 0) {
                    return;
                }

                # Removing Google's random Z from timestamp
                $timestamp = $node->filter('time')->attr('datetime');
                $date_split = explode('Z', $timestamp);
                $published = $date_split[0];

                $article = new Article();
                $article->headline      = $node->filter('h3 > a')->text();
                $article->url           = $article_url;
                $article->source        = $node->filter('a.wEwyrc')->text();
                $article->topic         = $topic;
                $article->ranking       = $ranking;
                $article->published     = $published;

                $article->save();
                $item->articles()
                ->save($article);
            });
        })->wait();
    }
}

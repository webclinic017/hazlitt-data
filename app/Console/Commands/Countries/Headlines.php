<?php

namespace App\Console\Commands\Countries;

use App\Article;
use App\Country;
use Illuminate\Support\Carbon;
// use Goutte\Client;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Symfony\Component\DomCrawler\Crawler;

use Illuminate\Console\Command;

class Headlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:headlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape trending country headlines from Google News';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = microtime(true);
        $countries = Country::all();

        foreach ($countries as $country) {
            $client = new Client();
            $topics = Country::$topics;

            Article::where('item_id', '=', $country->id)
                ->where('item_type', '=', 'App\Country')
                ->delete();

            foreach ($topics as $topic) {
                $query = strtolower(str_replace(' ', '+', $country->name)) . '+' . $topic;
                $this->comment("\n" . 'https://news.google.com/search?q=' . $query);

                $promise = $client->requestAsync('GET', 'https://news.google.com/search?q=' . $query);
                $promise->then(function ($response) use ($country, $topic) {
                    $body = $response->getBody()->getContents();

                    $crawler = new Crawler($body);
                    $crawler->filter('article')->each(function ($node, $ranking) use ($country, $topic) {
                        if (!isset($node)) {
                            $this->warn('No articles for ' . $country->name);
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
                        
                        $href = $node->filter('article > a')->attr('href');
                        $article_url = 'https://news.google.com/' . $href;

                        $duplicate = Article::where('item_id', '=', $country->id)
                            ->where('item_type', '=', 'App\Country')
                            ->where('url', '=', $article_url)
                            ->count();
                        if ($duplicate != 0) {
                            $this->warn('Duplicate article');
                            return;
                        }

                        # Removing Google's random Z from timestamp
                        $timestamp = $node->filter('time')->attr('datetime');
                        $date_split = explode('Z', $timestamp);
                        $date_string = $date_split[0];

                        # Removing random T from timestamp
                        $time_split = explode("T", $date_string);
                        $published = implode(" ", $time_split);

                        $article = new Article();
                        $article->headline      = $node->filter('h3 > a')->text();
                        $article->url           = $article_url;
                        $article->source        = $node->filter('a.wEwyrc')->text();
                        $article->topic         = $topic;
                        $article->ranking       = $ranking;
                        $article->published     = $published;

                        $article->save();
                        $country->articles()
                            ->save($article);

                        $this->info($country->name . ' - ' . $article->source . ' saving article to database');
                    });
                })->wait();
            }
        }
        $end = microtime(true);
        $time = number_format($end - $start);
        $this->info("\n" . 'Done: ' . $time . ' seconds');
    }
}

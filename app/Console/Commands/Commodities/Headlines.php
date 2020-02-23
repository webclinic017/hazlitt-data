<?php

namespace App\Console\Commands\Commodities;

use App\Article;
use App\Commodity;
use Illuminate\Support\Carbon;
use Goutte\Client;
use Illuminate\Support\Arr;

use Illuminate\Console\Command;

class Headlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commodity:headlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape trending commodity headlines from Google News';

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
        $commodities = Commodity::all();

        foreach ($commodities as $commodity) {
            $client = new Client();
            $topics = collect(Commodity::$topics);
            Article::where('item_id', '=', $commodity->id)
                ->where('item_type', '=', 'App\Commodity')
                ->delete();

            $topics->each(function ($topic) use ($commodity, $client) {
                $query = strtolower(str_replace(' ', '+', $commodity->name)) . '+' . $topic;
                try {
                    $this->comment("\n" . 'https://news.google.com/search?q=' . $query);
                    $crawler = $client->request('GET', 'https://news.google.com/search?q=' . $query);

                    $crawler->filter('article')->each(function ($node, $ranking) use ($commodity, $topic) {
                        if (!isset($node)) {
                            $this->warn('No articles for ' . $commodity->name);
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
                            $this->warn('Duplicate article');
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
                        $commodity->articles()
                            ->save($article);

                        $this->info($commodity->name . ' - ' . $article->source . ' saving article to database');
                    });
                } catch (\Exception $e) {
                    $this->error($e);
                    report($e);
                }
            });
        }
        $end = microtime(true);
        $time = number_format(($end - $start) / 60);
        $this->info("\n" . 'Done: ' . $time . ' minutes');
    }
}

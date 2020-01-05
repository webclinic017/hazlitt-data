<?php

namespace App\Console\Commands\Commodities;

use App\Article;
use App\Commodity;
use Illuminate\Support\Carbon;
use Goutte\Client;

use Illuminate\Console\Command;

class Headlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commodities:headlines';

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
            $queries = collect([
                'prices' => strtolower(str_replace(' ', '+', $commodity->name)) . '+prices',
                'supply' => strtolower(str_replace(' ', '+', $commodity->name)) . '+supply',
                'demand' => strtolower(str_replace(' ', '+', $commodity->name)) . '+demand'
            ]);

            Article::where('item_id', '=', $commodity->id)->delete();

            $queries->each(function ($value, $query) use ($commodity, $client) {

                try {
                    $this->comment("\n" . 'https://news.google.com/search?q=' . $value);
                    $crawler = $client->request('GET', 'https://news.google.com/search?q=' . $value);

                    $crawler->filter('article')->each(function ($node) use ($commodity, $query) {

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
                        $jslog = $node->filter('article a')->attr('jslog');
                        $jslog_split = explode(";", $jslog);
                        $url_stripped = explode(":", $jslog_split[1], 2);
                        $article_url = $url_stripped[1];

                        # Removing Google's random Z from timestamp
                        $timestamp = $node->filter('time')->attr('datetime');
                        $date_split = explode('Z', $timestamp);
                        $release_date = $date_split[0];


                        $article = Article::create([
                            'item_id' => $commodity->id,
                            'item_type' => 'App\Commodity',
                            'headline' => $node->filter('h3 > a')->text(),
                            'url' => $article_url,
                            'source' => $node->filter('a.wEwyrc')->text(),
                            'subject' => $commodity->name,
                            'topic' => $query,
                            'release_date' => $release_date
                        ]);

                        $article->save();
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

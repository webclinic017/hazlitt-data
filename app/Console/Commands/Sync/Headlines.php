<?php

namespace App\Console\Commands\Sync;

use App\News;
use App\Commodity;
use Illuminate\Support\Carbon;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

use Illuminate\Console\Command;

class Headlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:headlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get todays headlines from the Google News API';

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
        $commodities = Commodity::all();

        foreach ($commodities as $commodity) {
            $client = new Client();

            try {
                $crawler = $client->request('GET', 'https://news.google.com/search?q=' . $commodity->queries['prices']);
                $commodity_id = $commodity->id;
                $crawler->filter('article')->each(function ($node) use ($commodity_id) {

                    $jslog = $node->filter('article a')->attr('jslog');                    
                    $jslog_split = explode(";", $jslog);
                    $url_stripped = explode(":", $jslog_split[1], 2);
                    $article_url = $url_stripped[1];

                    $news = News::updateOrCreate([
                        'url' => $article_url
                    ], [
                        'commodity_id' => $commodity_id,
                        'headline' => $node->filter('h3 > a')->text(),
                        'source' => $node->filter('a.wEwyrc')->text(),
                        'release_date' => $node->filter('time')->attr('datetime')
                    ]);

                    $news->save();
                    $this->info('Saving ' . $news->source . ' article to database');
                });

            } catch (\Exception $e) {
                $this->error($e);
                report($e);
            }
        }
    }
}

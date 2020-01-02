<?php

namespace App\Console\Commands\Headlines;

use Illuminate\Console\Command;
use App\Article;
use App\Country;
use Illuminate\Support\Carbon;
use Goutte\Client;

class CountryHeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'headlines:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape news articles about each country';

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
            $queries = collect([
                'economy' => strtolower(str_replace(' ', '+', $country->name)) . '+economy',
                'interest-rates' => strtolower(str_replace(' ', '+', $country->name)) . '+interest+rates',
            ]);

            Article::where('entry_id', '=', $country->id)->delete();

            $queries->each(function ($value, $query) use ($country, $client) {

                try {
                    $this->comment("\n" . 'https://news.google.com/search?q=' . $value);
                    $crawler = $client->request('GET', 'https://news.google.com/search?q=' . $value);

                    $crawler->filter('article')->each(function ($node) use ($query, $country) {

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
                            'entry_id' => $country->id,
                            'entry_type' => 'App\Country',
                            'headline' => $node->filter('h3 > a')->text(),
                            'url' => $article_url,
                            'source' => $node->filter('a.wEwyrc')->text(),
                            'item' => $country->name,
                            'subject' => $query,
                            'release_date' => $release_date
                        ]);

                        $article->save();
                        $this->info($country->name . ' - ' . $article->source . ' saving article to database');
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

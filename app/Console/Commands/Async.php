<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use App\Commodity;
use App\Article;
use App\Jobs\Checkout\AsyncHTTP as CheckoutAsyncHTTP;
use Symfony\Component\DomCrawler\Crawler;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
use App\Jobs\AsyncScraper;
use Spatie\Async\Pool;

class Async extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'async:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $pool = Pool::create();

        foreach ($commodities as $commodity) {
            $pool->add(function () use ($commodity) {
                $client = new Client();
                $topics = Commodity::$topics;
                Article::where('item_id', '=', $commodity->id)
                ->where('item_type', '=', 'App\Commodity')
                ->delete();

                foreach ($topics as $topic) {
                    $query = strtolower(str_replace(' ', '+', $commodity->name)) . '+' . $topic;
                    AsyncScraper::dispatch($commodity, $topic);
                    print 'https://news.google.com/search?q=' . $query;
                }
            })->then(function ($output) {
                // Handle success
            })->catch(function (Throwable $exception) {
                // Handle exception
            });
        }

        $pool->wait();
        $end = microtime(true);
        $time = number_format(($end - $start) / 60);
        $this->info("\n" . 'Done: ' . $time . ' minutes');


        // $start = microtime(true);
        // $commodities = Commodity::all();

        // foreach ($commodities as $commodity) {
        //     $client = new Client();
        //     $topics = Commodity::$topics;
        //     Article::where('item_id', '=', $commodity->id)
        //         ->where('item_type', '=', 'App\Commodity')
        //         ->delete();

        //     foreach ($topics as $topic) {
        //         $query = strtolower(str_replace(' ', '+', $commodity->name)) . '+' . $topic;
        //         AsyncScraper::dispatch($commodity, $topic);
        //         $this->info('https://news.google.com/search?q=' . $query);
        //     }
        // }
        // $end = microtime(true);
        // $time = number_format(($end - $start) / 60);
        // $this->info("\n" . 'Done: ' . $time . ' minutes');
    }
}

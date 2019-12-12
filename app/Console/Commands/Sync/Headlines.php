<?php

namespace App\Console\Commands\Sync;
use SimpleXMLElement;
use App\News;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;

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
        $url = "https://newsapi.org/";

        $client = new Client([
            'base_uri' => $url,
            'headers'  => [
                'Accept-Encoding' => 'gzip',
            ],
        ]);

        try {
            $response = $client->request('GET', 'v2/everything', [
                'query' => [
                    'q'   => "coffee+prices",
                    'from' => Carbon::now('America/Denver')->format('Y/m/d'),
                    'sources' => ['bloomberg', 'australian-financial-review', 'business-insider'],
                    'sortBy' => 'popularity',
                    'apiKey' => config('services.news.key'),
                    'debug' => true
                ],
            ]);
            $xml = $response->getBody()->getContents();
            // dd($response);
            // dd($xml);
        
        } catch (\Exception $e) {
            $this->error($e);
            report($e);
        }

        
    }
}

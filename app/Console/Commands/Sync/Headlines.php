<?php

namespace App\Console\Commands\Sync;
use SimpleXMLElement;
use App\News;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;

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
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request('GET', 'https://newsapi.org/v2/everything', [
                'query' => [
                    'q'   => "coffee+prices",
                    'from' => Carbon::now('America/Denver')->format('Y/m/d'),
                    'sources' => ['bloomberg', 'australian-financial-review', 'business-insider'],
                    'sortBy' => 'popularity',
                    'apiKey' => config('services.news.key'),                                   
                ],
            ]);

            $json = $response->getBody()->getContents();
            // dd($json);
            
            if ((int) $response->getStatusCode() == 200) {
                $headlines = json_decode($json, true);                

                foreach($headlines as $i => $v) {
                    // dd($i);
                    $this->info($i[1]);

                    // $news = News::create([
                    //     'headline' => $article['title'],
                    //     'source' => $article['source'],
                    //     'url' => $article['url'],
                    //     'release_date' => $article['publishedAt'],
                    // ]);
                    // $news->save();
                    // $this->info($article['title'] . ' - saved');
                }                
            }

        } catch (\Exception $e) {
            $this->error($e);
            report($e);
        }

        
    }
}

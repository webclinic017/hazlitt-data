<?php

namespace App\Console\Commands\Sync;

use App\News;
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
                $crawler->filter('h3 > a')->each(function ($node) {
                    $this->info($node->text() . "\n");
                    $news = News::create([
                        'commodity_id' => $commodity->id,
                        'headline' => $node->text(),
                        ''                        
                    ]);
                    $news->save();                    
                });
                
                // $crawler->filter('a.wEwyrc')->each(function ($node) {
                //     $this->info($node->text()."\n");
                // });


            } catch (\Exception $e) {
                $this->error($e);
                report($e);
            }
        }
    }
}

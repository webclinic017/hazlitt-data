<?php

namespace App\Console\Commands\Commodities;

use Illuminate\Console\Command;
use App\Commodity;
use Illuminate\Support\Carbon;
use Goutte\Client;
use Illuminate\Support\Arr;

class SpotPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commodity:spot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab spot prices for all commodities.';

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
        $client = new Client();
        try {
            $crawler = $client->request('GET', env('SPOT_URL'));

            $crawler->filter('body')->each(function ($node) {
                if ($node->filter('td.datatable-item-first')->count() == 0) {
                    $this->error('Bad selector');
                    return;
                }
                dd($node->filter('td.datatable-item-first')->text());

            });
            $this->info('Saved ' . $commodity->name . ' spot price');
        } catch (\Exception $e) {
            $this->error($e);
            report($e);
        }
            
        
        $end = microtime(true);
        $time = number_format(($end - $start)/60);
        $this->info("\n" . 'Done: ' . $time . ' minutes');
    }
}

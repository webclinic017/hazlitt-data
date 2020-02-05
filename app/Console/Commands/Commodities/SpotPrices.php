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
        $client = new Client();
        try {
            $this->comment('Getting...');
            $crawler = $client->request('GET', env('SPOT_URL'));

            $crawler->filter('body')->each(function ($node) {                

                $node->filter('tr')->each(function ($row) use ($node) {
                    if ($row->filter('td.datatable-item-first')->count() == 0) {                        
                        return;
                    }

                    $item = $row->filter('td.datatable-item-first')->text();
                    $this->comment('Getting ' . $item . '...');
                    $price_change = '#nch';
                    $day = '#pch';
                    $week = 'td:nth-child(6)';
                    $month = 'td:nth-child(7)';
                    $year =  'td:nth-child(8)';
                    $spot = $row->filter('#p')->text();

                    if( strpos($spot, ',') !== false ) {
                        $spot = str_replace(',', null, $spot);
                    }
                    
                    $change = collect([
                        'price-change' => (float) $row->filter($price_change)->text(),
                        'day' => (float) $row->filter($day)->text(),
                        'weekly' => (float) $row->filter($week)->text(),
                        'monthly' => (float) $row->filter($month)->text(),
                        'yearly' => (float) $row->filter($year)->text(),
                    ]);                    

                    $commodity = Commodity::where('name', '=', $item)->first();
                    if (!$commodity) {
                        return;
                    }
                    $commodity->spot = (float) $spot;
                    $commodity->change = $change;
                    $commodity->save();
                    $this->info($row->text() . ' - Saved.');
                });
            });
            // $this->info('Saved ' . $commodity->name . ' spot price');
        } catch (\Exception $e) {
            $this->error($e);
            report($e);
        }
            
        
        $end = microtime(true);
        $time = number_format(($end - $start)/60);
        $this->info("\n" . 'Done: ' . $time . ' minutes');
    }
}

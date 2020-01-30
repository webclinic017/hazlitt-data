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
            $crawler = $client->request('GET', env('SPOT_URL'));

            $crawler->filter('body')->each(function ($node) {
                if ($node->filter('td.datatable-item-first')->count() == 0) {
                    $this->error('Bad selector');
                    return;
                }

                $node->filter('td.datatable-item-first')->each(function ($item) use ($node) {
                    $this->comment('getting ' . $item->text() . '...');
                    $price_change = '#nch';
                    $day = '#pch';
                    $week = '#aspnetForm > div.container > div > div.col-lg-8.col-md-9 > div > div:nth-child(3) > table > tbody > tr:nth-child(1) > td:nth-child(6)';
                    $month = '#aspnetForm > div.container > div > div.col-lg-8.col-md-9 > div > div:nth-child(3) > table > tbody > tr:nth-child(1) > td:nth-child(7)';
                    $year =  '#aspnetForm > div.container > div > div.col-lg-8.col-md-9 > div > div:nth-child(3) > table > tbody > tr:nth-child(1) > td:nth-child(8)';
                    $spot = $node->filter('#p')->text();
                    
                    $change = collect([
                        'price-change' => $node->filter($price_change)->text(),
                        'day' => $node->filter($day)->text(),
                        'weekly' => $node->filter($week)->text(),
                        'monthly' => $node->filter($month)->text(),
                        'yearly' => $node->filter($year)->text(),
                    ]);
                    
                    $commodity = Commodity::where('name', '=', $item->text())->first();
                    if (!$commodity) {
                        return;
                    }
                    $commodity->spot = $spot;
                    $commodity->change = $change;
                    $commodity->save();
                    $this->info($item->text() . ' prices saved.');
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

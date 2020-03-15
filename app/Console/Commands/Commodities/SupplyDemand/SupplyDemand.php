<?php

namespace App\Console\Commands\Commodities\SupplyDemand;

use Illuminate\Console\Command;

class SupplyDemand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commodity:supplydemand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collects supply and demand statistics from various sources';

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
        $commodities = Commodity::whereJsonLength('sources->quandl', 1)->get();
        
        $directory = 'storage/imports/commodity';

        $row = 1;
        if (($handle = fopen($directory . '/AgricultureSupplyDemand.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 0, ",")) !== false) {
                $commodity = Commodity::create([
                    'name' => $data[0],
                    'slug' => strtolower(str_replace(' ', '-', $data[0])),
                    'code' => $data[1],
                    'sources' => [ $data[2] => $data[1],],
                    'status' => 1,
                ]);

                $entry = new Registry();

                $entry->url              = 'commodities/' . $commodity->slug;
                $entry->destination      = 'Main\CommodityController@router';
                $entry->layout           = 'main.layouts.app';
                $entry->view             = 'commodities.show';
                $entry->redirect         = false;
                $entry->code             = 200;
                $entry->meta_title       = $commodity->name . ' News and Prices';
                $entry->meta_keywords    = 'Hazlitt Data, ' . $commodity->name . ', news and data';
                $entry->meta_description = 'Hazlitt Data - ' . $commodity->name . ' prices, news and data';
                $entry->meta_robots      = 'INDEX, FOLLOW';

                $entry->save();

                $commodity->registry()
                ->save($entry);
            }
            fclose($handle);
        }
    }
}

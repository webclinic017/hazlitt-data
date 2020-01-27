<?php

namespace App\Console\Commands\Commodities;

use Illuminate\Console\Command;
use App\Commodity;
use Illuminate\Support\Carbon;
use Unirest\Request;
use Unirest\Request\Header;
use Unirest\Request\Body;
use Illuminate\Support\Arr;

class HistoricalPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commodity:historical_prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch commodity prices from the Quandl API';

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
        $commodities = Commodity::where('source', '=', 'quandl')->get();
        
        $url = config('services.quandl.url');
        $api_key = config('services.quandl.key');

        foreach ($commodities as $commodity) {
            try {                
                $this->comment($commodity->name . " - " . $url . $commodity->code . '?api_key=' . $api_key);
                $response = Request::get($url . $commodity->code . '?api_key=' . $api_key);
                if ($response->code == 200) {
                    $object = last($response->body);
                    $columns = collect($object->column_names);
                        
                    $prices = collect();
                    foreach ($object->data as $array) {
                        $collection = $columns->combine($array);
                        $prices->push($collection);
                    }
                    $commodity->prices = $prices;
                    $commodity->save();
                    $this->info('Saved ' . $commodity->name . ' prices');
                } else {
                    $this->error($response->code);
                    $this->error($commodity->name);
                }
            } catch (\Exception $e) {
                $this->error($e);
                report($e);
            }
        }
        $end = microtime(true);
        $time = number_format(($end - $start) / 60);
        $this->info("\n" . 'Done: ' . $time . ' minutes');
    }
}

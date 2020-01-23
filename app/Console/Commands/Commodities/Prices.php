<?php

namespace App\Console\Commands\Commodities;

use Illuminate\Console\Command;
use App\Commodity;
use Illuminate\Support\Carbon;
use Unirest\Request;
use Unirest\Request\Header;
use Unirest\Request\Body;
use Illuminate\Support\Arr;

class Prices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commodity:prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch commodity prices from API';

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
        
        $url = config('services.quandl.url');
        $api_key = config('services.quandl.key');

        foreach ($commodities as $commodity) {
            if ($commodity->source == 'quandl') {
                try {
                    $this->comment($commodity->name . " - " . $url . $commodity->code . '?api_key=' . $api_key);
                    $response = Request::get($url . $commodity->code . '?api_key=' . $api_key);
                    if ($response->code == 200) {
                        $object = last($response->body);                        
                        $columns = $object->column_names;                     
                        // $this->info(collect($columns));
                        
                        // $collection = collect();
                        // if (gettype($object) == 'object') {
                        //     foreach ($object->data as $array) {
                        //         $count = count($array);
                        //         $collection->push([
                        //             'date' => $array[0],
                        //             'last' => $array[1],
                        //         ]);
                        //     }
                        // }
                    } else {
                        $this->error($response->code);
                        $this->error($commodity->name);
                    }
                } catch (\Exception $e) {
                    $this->error($e);
                    report($e);
                }
            }
        }
        $end = microtime(true);
        $time = number_format(($end - $start) / 60);
        $this->info("\n" . 'Done: ' . $time . ' minutes');
    }
}

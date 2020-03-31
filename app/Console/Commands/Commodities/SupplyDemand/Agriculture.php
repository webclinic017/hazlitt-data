<?php

namespace App\Console\Commands\Commodities\SupplyDemand;

use Illuminate\Console\Command;
use SimpleExcel\SimpleExcel;
use App\Commodity;
use Illuminate\Support\Arr;

class Agriculture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplydemand:agriculture';

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
        $commodities = Commodity::where('sector', '=', 'Agricultural')->get();
        $directory = 'storage/imports/commodity/supplydemand/agriculture';
        $excel = new SimpleExcel('csv');

        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file == "." || $file == ".." || $file == ".DS_Store") {
                continue;
            }
            $excel->parser->loadFile($directory . '/' . $file);

            $headers = $excel->parser->getRow(1);
            $rows = $excel->parser->getField();
            $years = array_slice($headers, 2); 
            
            $data = [];
            //Variables
            foreach ($rows as $x => $row) {
                $x = $x + 1;
                foreach ($years as $y => $year) {
                    $y = $y + 1;
                    $this->info($x, $y);
                    $cell = $excel->parser->getCell($x, $y);
                    // $this->info($cell);
                }
                 
            }            
        }
    }
}

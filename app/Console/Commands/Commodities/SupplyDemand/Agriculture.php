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
        $directory = 'storage/imports/commodity/agriculture';
        $excel = new SimpleExcel('csv');

        $files = scandir($directory);
        foreach ($files as $file) {    
            if ($file == "." || $file == ".." || $file == ".DS_Store") { continue; }            
            $excel->parser->loadFile($directory . '/' . $file);

            $rows = $excel->parser->getField();
            dd($rows);
            foreach ($rows as $i => $row) {
                $i = $i + 1; // Excel sheet starts at 1.
                // $ticker = $excel->parser->getCell($i, 1);
                // $name = $excel->parser->getCell($i, 2);

                // $stock = new Stock();
                // $stock->name = $name;
                // $stock->ticker = $ticker;
                // $stock->index_id = $index->id;
                // $stock->save();
            }
        }
    }
}

<?php

namespace App\Console\Commands\Stocks;

use App\Stock;
use App\Index;

use Illuminate\Console\Command;

class IndexCollector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stocks:indices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get information from the Russell3000';

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
        $directory = 'storage/imports';
        $indices = Index::all();

        foreach ($indices as $index) {
            // $row = 1;
            // if (($handle = fopen($directory . '/' . $index->source, "r")) !== false) {
            //     while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            //         if ($data != null) {
            //         $data = collect($data);
            //         $stock = new Stock();
            //         $stock->name = $data->first();
            //         $stock->ticker = $data->last();
            //         $stock->save();                                            
            //         }                    
            //     }
            //     fclose($handle);
            // }
        }
    }
}

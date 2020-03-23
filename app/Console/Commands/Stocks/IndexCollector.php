<?php

namespace App\Console\Commands\Stocks;

use App\Stock;
use App\Index;
use \Digitonic\IexCloudSdk\Facades\Stocks\AdvancedStats;
use \Digitonic\IexCloudSdk\Facades\Stocks\BalanceSheet;
use \Digitonic\IexCloudSdk\Facades\Stocks\Company;
use \Digitonic\IexCloudSdk\Facades\Stocks\Price;

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
        $pubilc_key = env('services.iex.public');
        // $stocks = Stocks::all();
        $stock = "GOOG";

        $response = Company::setSymbol($stock)->get();
        dd($response);

        // foreach ($stocks as $stock) {

        // }
    }
}

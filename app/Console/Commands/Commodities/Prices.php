<?php

namespace App\Console\Commands\Commodities;

use Illuminate\Console\Command;
use App\Commodity;

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
    protected $description = 'API Call to Quandl for commodity price data';

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
        //
    }
}

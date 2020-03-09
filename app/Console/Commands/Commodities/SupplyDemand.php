<?php

namespace App\Console\Commands\Commodities;

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
        //
    }
}

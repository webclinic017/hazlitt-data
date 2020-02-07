<?php

namespace App\Console\Commands\Stocks;

use Illuminate\Console\Command;

class IndexCollector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stocks:indeces';

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
        //
    }
}

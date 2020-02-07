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

        $files = array();
        foreach (scandir($directory) as $file) {            
            if ($file !== '.' && $file !== '..') {
                // $files[] = $file;
                // fgetcsv($file);
                // $this->info($file);
                if (($handle = fopen($directory . '/' . $file, "r")) !== FALSE) {
                    $csv = fgetcsv($handle);
                    dd($csv);
                    // while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    //     $num = count($data);
                    //     echo "<p> $num fields in line $row: <br /></p>\n";
                    //     $row++;
                    //     for ($c=0; $c < $num; $c++) {
                    //         echo $data[$c] . "<br />\n";
                    //     }
                    // }
                    // fclose($handle);
                }
            }
        }

        dd($files);
    }
}

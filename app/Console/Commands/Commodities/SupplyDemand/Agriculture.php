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
    protected $signature = 'supplydemand:ag';

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
        function formatArray($array, $years)
        {
            foreach ($array as $item) {
                mb_convert_encoding($item, 'UTF-8', 'UTF-8');
            }
            $array["Variable"] = trim($array["Variable"]);
            $formattedArray = $array->only('Variable', 'Unit');
            $yearlyData = $array->splice(2);
            $timeTable = collect($years)->combine($yearlyData);
            $formattedArray['years'] = $timeTable;

            return $formattedArray;
        }

        //Start CSV parse
        $directory = 'storage/imports/commodity/supplydemand/agriculture';
        $excel = new SimpleExcel('csv');
        $files = scandir($directory);

        foreach ($files as $file) {
            if ($file == "." || $file == ".." || $file == ".DS_Store") {
                continue;
            }
            $fileName = explode('.', $file);
            $commodityName = $fileName[0];
            $commodity = Commodity::where('name', '=', $commodityName)->first();
            if ($commodity) {
                $excel->parser->loadFile($directory . '/' . $file);

                $rows = $excel->parser->getField();
                $headers = $excel->parser->getRow(1);
                $years = array_slice($headers, 2);

                //Values
                foreach ($rows as $x => $row) {
                    if ($x < 2) {
                        continue;
                    }
                
                    $fields[$x] = $excel->parser->getRow($x);
                }
                //Merging arrays
                foreach ($fields as $i => $cells) {
                    $data[$i] = collect($headers)->combine(collect($cells));
                }

                //Formatting
                foreach ($data as $i => $array) {
                    $dataFormatted[$i] = formatArray($set, $years);
                }

                //Cleaning up
                $indexedArray = collect($dataFormatted)->values();
                $cleanedData = $indexedArray->toArray();

                //Save
                $commodity->update([
                    'supply_demand' => $cleanedData,
                ]);
                $this->info('saved ' . $commodity->name);
            }
        }
    }
}

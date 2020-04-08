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
        $directory = 'storage/imports/commodity/supplydemand/agriculture';
        $excel = new SimpleExcel('csv');
        $files = scandir($directory);

        function cleanArray($array, $years)
        {
            $array["Variable"] = trim($array["Variable"]);
            $cleanedArray = $array->only('Variable', 'Unit');
            $yearlyData = $array->splice(2);
            $timeTable = collect($years)->combine($yearlyData);
            $cleanedArray['years'] = $timeTable;

            return $cleanedArray->toArray();
        }


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
                foreach ($fields as $i => $set) {
                    $data[$i] = collect($headers)->combine(collect($set));
                }

                //Cleaning up
                foreach ($data as $i => $array) {
                    $cleanData[$i] = cleanArray($array, $years);
                }
                // $dataJson = collect($cleanData)->toJson();                
                //Save
                $commodity->update([
                    'supply_demand' => $cleanData,
                ]);           
                // dd($commodity);
                // $commodity->save();                
            }
        }
    }
}

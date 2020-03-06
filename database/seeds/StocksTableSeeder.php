<?php

use Illuminate\Database\Seeder;
use App\Index;
use App\Stock;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stock::truncate();
        $directory = 'storage/imports/stock';
        $indices = Index::all();

        foreach ($indices as $index) {
            $row = 1;
            if (($handle = fopen($directory . '/' . $index->source, "r")) !== false) {
                while (($data = fgetcsv($handle, 0, ",")) !== false) {
                    $data = collect($data);
                    $stock = new Stock();
                    $stock->name = $data->last();
                    $stock->ticker = $data->first();
                    $stock->index_id = $index->id;                                          
                    $stock->save();                    
                }
                fclose($handle);
            }
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Index;
use App\Stock;

use SimpleExcel\SimpleExcel;

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
        $excel = new SimpleExcel('csv');

        foreach ($indices as $index) {
            $excel->parser->loadFile($directory . '/' . $index->source);
            $rows = $excel->parser->getField();
            foreach ($rows as $i => $row) {
                $i = $i + 1; // Excel sheet starts at 1.
                $ticker = $excel->parser->getCell($i, 1);
                $name = $excel->parser->getCell($i, 2);

                $stock = new Stock();
                $stock->name = $name;
                $stock->ticker = $ticker;
                $stock->index_id = $index->id;
                $stock->save();
            }            
        }
    }
}

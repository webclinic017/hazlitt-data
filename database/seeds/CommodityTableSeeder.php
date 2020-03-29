<?php

use Illuminate\Database\Seeder;
use App\Commodity;
use App\Registry;
use Illuminate\Support\Facades\DB;
use SimpleExcel\SimpleExcel;

class CommodityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commodities = Commodity::all();
        foreach ($commodities as $commodity) {
            DB::table('registry')
            ->where('entry_type', '=', 'App\Commodity')
            ->where('entry_id', '=', $commodity->id)
            ->delete();
        }
        
        Commodity::truncate();
    
        $directory = 'storage/imports/commodity';
        $excel = new SimpleExcel('csv');
        $excel->parser->loadFile($directory . '/Commodities.csv');

        $rows = $excel->parser->getField();

        foreach ($rows as $i => $row) {
            $i = $i + 1; // Excel sheet starts at 1.
            $name = $excel->parser->getCell($i, 1);
            $sector = $excel->parser->getCell($i, 2);
            $sourceCode = collect(explode('=>', $excel->parser->getCell($i, 3)));
            $source = $sourceCode->first();
            $code = $sourceCode->last();

            $commodity = Commodity::create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'sector' => $sector,
                'sources' => [ $source => $code,],
                'status' => 1,
            ]);

            $entry = new Registry();

            $entry->url              = 'commodities/' . $commodity->slug;
            $entry->destination      = 'Main\CommodityController@router';
            $entry->layout           = 'main.layouts.app';
            $entry->view             = 'commodities.show';
            $entry->redirect         = false;
            $entry->code             = 200;
            $entry->meta_title       = $commodity->name . ' News and Prices';
            $entry->meta_keywords    = 'Hazlitt Data, ' . $commodity->name . ', news and data';
            $entry->meta_description = 'Hazlitt Data - ' . $commodity->name . ' prices, news and data';
            $entry->meta_robots      = 'INDEX, FOLLOW';

            $entry->save();

            $commodity->registry()
                ->save($entry);
        }
    }
}

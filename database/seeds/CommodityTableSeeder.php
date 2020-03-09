<?php

use Illuminate\Database\Seeder;
use App\Commodity;
use App\Registry;
use Illuminate\Support\Facades\DB;

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

        $row = 1;
        if (($handle = fopen($directory . '/Commodities.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 0, ",")) !== false) {
                $commodity = Commodity::create([
                    'name' => $data[0],
                    'slug' => strtolower(str_replace(' ', '-', $data[0])),
                    'code' => $data[1],
                    'sources' => [ $data[2] => $data[1],],
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
            fclose($handle);
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Commodity;
use App\Registry;

class CommodityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Commodity::truncate();
                
        $commodities = new Commodity();
        $commodity_codes = $commodities->codes();        

        $commodity_codes->each(function ($data, $type) {			
            $commodity = Commodity::create([
                'name' => $type,
                'slug' => strtolower(str_replace(' ', '-', $type)),
				'code' => collect($data)->get('code'),
				'source' => collect($data)->get('source'),
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
        });
    }
}

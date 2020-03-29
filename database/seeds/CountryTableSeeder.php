<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\Registry;
use Illuminate\Support\Facades\DB;
use SimpleExcel\SimpleExcel;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    
    public function run()
    {
        $countries = Country::all();
        foreach ($countries as $country) {
            DB::table('registry')
            ->where('entry_type', '=', 'App\Country')
            ->where('entry_id', '=', $country->id)
            ->delete();
        }
        
        Country::truncate();  

        $directory = 'storage/imports/country';
        $excel = new SimpleExcel('csv');
        $excel->parser->loadFile($directory . '/Countries.csv');

        $rows = $excel->parser->getField();

        foreach ($rows as $i => $row) {
            $i = $i + 1; // Excel sheet starts at 1.
            $name = $excel->parser->getCell($i, 1);
            $code = $excel->parser->getCell($i, 2);

            $country = Country::create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'code' => $code,
                'status' => 1,
            ]);

            $entry = new Registry();

            $entry->url              = 'countries/' . $country->slug;
            $entry->destination      = 'Main\CountryController@router';
            $entry->layout           = 'main.layouts.app';
            $entry->view             = 'countries.show';
            $entry->redirect         = false;
            $entry->code             = 200;
            $entry->meta_title       = $country->name . ' News and Prices';
            $entry->meta_keywords    = 'Hazlitt Data, ' . $country->name . ', news and data';
            $entry->meta_description = 'Hazlitt Data - ' . $country->name . ' prices, news and data';
            $entry->meta_robots      = 'INDEX, FOLLOW';

            $entry->save();

            $country->registry()
                ->save($entry);
        }
    }
}

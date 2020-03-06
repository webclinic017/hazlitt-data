<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\Registry;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commodities = Country::all();
        foreach ($commodities as $country) {
            DB::table('registry')
            ->where('entry_type', '=', 'App\Country')
            ->where('entry_id', '=', $country->id)
            ->delete();
        }
        
        Country::truncate();  
        $directory = 'storage/imports/country';

        $row = 1;
        if (($handle = fopen($directory . '/Countries.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 0, ",")) !== false) {
                $country = Country::create([
                    'name' => $data[0],
                    'slug' => strtolower(str_replace(' ', '-', $data[0])),
                    'code' => $data[1],
                    'status' => 1,
                ]);

                $entry = new Registry();

                $entry->url              = 'commodities/' . $country->slug;
                $entry->destination      = 'Main\CountryController@router';
                $entry->layout           = 'main.layouts.app';
                $entry->view             = 'commodities.show';
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
            fclose($handle);
        }
    }
}

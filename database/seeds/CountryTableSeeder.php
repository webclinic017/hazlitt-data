<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\Registry;

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
        
        $countries = Country::$countries;
        $countries->each(function ($code, $name) {
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
        });
    }
}

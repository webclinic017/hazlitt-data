<?php

use Illuminate\Database\Seeder;
use App\Index;
use App\Country;

class IndexTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Index::truncate();

        $country = Country::where('name', '=', 'United States')->first();

        $index = Index::create([
            'name' => 'Dow Jones Industrial Average',
            'country_id' => $country->id,
            'country_name' => $country->name,
            'source' => 'DowJones.csv'
        ]);

        $index = Index::create([
            'name' => 'S&P 500',
            'country_id' => $country->id,
            'country_name' => $country->name,
            'source' => 'S&P500.csv'
        ]);

        $index = Index::create([
            'name' => 'Nasdaq Composite',
            'country_id' => $country->id,
            'country_name' => $country->name,
            'source' => 'NasdaqComposite.csv'
        ]);

        $index = Index::create([
            'name' => 'Russell 2000',
            'country_id' => $country->id,
            'country_name' => $country->name,
            'source' => 'Russell2000.csv'
        ]);

        $index = Index::create([
            'name' => 'Russell 3000',
            'country_id' => $country->id,
            'country_name' => $country->name,
            'source' => 'Russell3000.csv'
        ]);
    }
}

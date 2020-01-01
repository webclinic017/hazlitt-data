<?php

use Illuminate\Database\Seeder;
use App\Registry;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Registry::truncate();
        $this->call(CommodityTableSeeder::class);
        $this->call(CountryTableSeeder::class);      
    }
}

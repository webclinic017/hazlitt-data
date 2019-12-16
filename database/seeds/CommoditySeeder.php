<?php

use Illuminate\Database\Seeder;
use App\Commodity;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commodity = Commodity::create([			
			'name' => 'coffee',        
            'queries' => [
				'prices' => 'coffee+prices',
				'supply' => 'coffee+supply',
				'demand' => 'coffee+demand'
			],
		]);		
		$commodity->save();
    }
}

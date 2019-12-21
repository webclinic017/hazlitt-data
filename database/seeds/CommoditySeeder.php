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
        
        $commodity = Commodity::create([			
			'name' => 'gold',        
            'queries' => [
				'prices' => 'gold+prices',
				'supply' => 'gold+supply',
				'demand' => 'gold+demand'
			],
		]);		
        $commodity->save();
        
        $commodity = Commodity::create([			
			'name' => 'silver',        
            'queries' => [
				'prices' => 'silver+prices',
				'supply' => 'silver+supply',
				'demand' => 'silver+demand'
			],
		]);		
        $commodity->save();
        
        $commodity = Commodity::create([			
			'name' => 'copper',        
            'queries' => [
				'prices' => 'copper+prices',
				'supply' => 'copper+supply',
				'demand' => 'copper+demand'
			],
		]);		
		$commodity->save();
    }
}

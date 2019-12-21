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

		$commodity_types = [
			'Aluminum',
			'Antimony',
			'Apples',
			'Arsenic',
			'Barley',
			'Bauxite',
			'Bismuth',
			'Butter',
			'Cadmium',
			'Cattle',
			'Cement',
			'Cheese',
			'Chromium',
			'Coal',
			'Cobalt',
			'Cocoa',
			'Coffee',
			'Coke',
			'Copper',
			'Corn',
			'Corn Oil',
			'Cotton',
			'Cottonseed',			
			'Diamonds',
			'Eggs',
			'Electric Power',
			'Ethanol',
			'Fish',
			'Flaxseed',
			'Linseed Oil',
			'Fruits',
			'Gas',
			'Gasoline',
			'Gold',
			'Grain Sorghum',
			'Hay',
			'Heating Oil',
			'Hides',
			'Leather',
			'Hogs',
			'Honey',						
			'Iron',
			'Steel',
			'Lard',
			'Lead',
			'Lumber',
			'Magnesium',
			'Manganese',
			'Meats',
			'Mercury',
			'Milk',
			'Molybdenum',
			'Nickel',
			'Oats',
			'Olive Oil',
			'Onions',
			'Oranges',			
			'Palm Oil',
			'Paper',
			'Peanuts',			
			'Pepper',
			'Petroleum',
			'Plastics',
			'Platinum',
			'Potatoes',
			'Rice',
			'Rubber',
			'Rye',
			'Salt',
			'Sheep',			
			'Silk',
			'Silver',					
			'Soybeans',					
			'Sugar',
			'Sulfur',			
			'Tallow',
			'Tea',
			'Tin',
			'Titanium',
			'Tobacco',
			'Tungsten',
			'Turkeys',
			'Uranium',
			'Vanadium',
			'Vegetables',
			'Wheat',
			'Wool',
			'Zinc',
		];

		foreach ($commodity_types as $type) {			
			$commodity = Commodity::create([
				'name' => $type,
				'slug' => strtolower($type),
				'queries' => [
					'prices' => strtolower(str_replace(' ', '+', $type)) . '+prices',
					'supply' => strtolower(str_replace(' ', '+', $type)) . '+supply',
					'demand' => strtolower(str_replace(' ', '+', $type)) . '+demand',
				],
			]);						

			$entry = new Registry();

			$entry->url              = $commodity->slug;
			$entry->destination      = 'Main\CommodityController@consume';
			$entry->layout           = 'main.layouts.app';
			$entry->view             = 'main.scripts.products.index';
			$entry->redirect         = false;
			$entry->code             = 200;
			$entry->meta_title       = 'Volcano Helicopter Tours in Big Island - Blue Hawaiian Helicopters';
			$entry->meta_keywords    = 'Big Island Helicopter Tours, Sightseeing Helicopter Tours on Big Island';
			$entry->meta_description = 'Blue Hawaiian&rsquo;s amazing volcano helicopter tours in Hawaii allow you to get an up-close glimpse of some of the world&rsquo;s most beautiful active volcanoes from the sky!';
			$entry->meta_robots      = 'INDEX, FOLLOW';

			$entry->save();

			$commodity->registry()
				->save($entry);
		}
	}
}
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
		Registry::truncate();

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
                'slug' => strtolower(str_replace(' ', '-', $type)),
                'status' => 1,
			]);						

			$entry = new Registry();

			$entry->url              = 'commodities/' . $commodity->slug;
			$entry->destination      = 'Main\CommodityController@router';
			$entry->layout           = 'main.layouts.app';
			$entry->view             = 'commodities.index';
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
	}
}
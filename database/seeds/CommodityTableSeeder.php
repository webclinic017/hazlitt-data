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
		
		//All commodities with quandl codes
		$commodities_codes = collect([
			'Aluminum' => 'LME/PR_AL',
			'Antimony' => '',
			'Apples' => '',	
			'Arsenic' => '',	
			'Bananas' => 'ODA/PBANSOP_USD',
			'Barley' => 'WORLDBANK/WLD_BARLEY',
			'Bauxite' => '',	
			'Bismuth' => '',	
			'Butter' => '',	
			'Brent Oil' => 'CHRIS/ICE_B1',
			'Cadmium' => '',	
			'Cattle' => 'ODA/PBEEF_USD',
			'Cement' => '',	
			'Cheese' => '',	
			'Chromium' => '',	
			'Coal' => 'EPI/152',
			'Cobalt' => 'LME/PR_CO',
			'Cocoa' => 'CHRIS/ICE_CC1',
			'Coffee' => 'CHRIS/ICE_KC1',
			'Coke' => '',
			'Copper' => 'LME/PR_CU',
			'Corn' => 'CHRIS/CME_C1',
			'Corn Oil' => '',	
			'Cotton' => 'CHRIS/ICE_CT1',
			'Cottonseed' => '',	
			'Crude Oil' => 'CHRIS/CME_CL1',
			'Diamonds' => '',	
			'Eggs' => '',	
			'Electric Power' => '',	
			'Ethanol' => '',	
			'Fish' => 'ODA/PFISH_USD',
			'Flaxseed' => '',	
			'Linseed Oil' => '',	
			'Fruits' => '',	
			'Gas' => '',	
			'Gasoline' => 'CHRIS/CME_RB1',
			'Gold' => 'CME_GC1',
			'Grain Sorghum' => '',	
			'Hay' => '',	
			'Heating Oil' => '',	
			'Hides' => 'ODA/PHIDE_USD',
			'Leather' => '',	
			'Hogs' => 'CHRIS/CME_LN1',
			'Honey' => '',	
			'Iridium' => 'JOHNMATT/IRID',
			'Iron' => 'ODA/PIORECR_USD',
			'Steel' => '',	
			'Lard' => 'ODA/PLAMB_USD',
			'Lead' => 'LME/PR_PB',
			'Lumber' => 'CHRIS/CME_LB1LME/PR_PB',
			'Magnesium' => '',	
			'Manganese' => '',	
			'Meats' => '',	
			'Mercury' => '',	
			'Milk' => 'CHRIS/CME_DA1',
			'Molybdenum' => 'LME/PR_MO',
			'Nickel' => 'LME/PR_NI',
			'Oats' => 'CHRIS/CME_O1',
			'Olive Oil' => 'ODA/POLVOIL_USD',
			'Onions' => '',	
			'Oranges' => 'ODA/PORANG_USD',
			'Orange Juice' => 'CHRIS/ICE_OJ1',
			'Palladium' => 'CHRIS/CME_PA1',
			'Palm Oil' => 'ODA/PPOIL_USD',
			'Paper' => '',	
			'Peanuts' => 'ODA/PGNUTS_USD',
			'Pepper' => '',	
			'Petroleum' => '',	
			'Plastics' => '',	
			'Platinum' => 'CHRIS/CME_PL1',
			'Potatoes' => '',	
			'Poultry' => 'ODA/PPOULT_USD',
			'Rapeseed Oil' => 'ODA/PROIL_USD',
			'Rhodium' => 'JOHNMATT/RHOD',
			'Rice' => 'CHRIS/CME_RR1',
			'Ruthenium' => 'JOHNMATT/RUTH',
			'Rubber' => 'ODA/PRUBB_USD',
			'Rye' => '',	
			'Salt' => '',	
			'Salmon' => 'ODA/PSALM_USD',
			'Sheep' => '',	
			'Shrimp' => 'ODA/PSHRI_USD',
			'Silk' => '',	
			'Silver' => 'CHRIS/CME_SI1',
			'Soybeans' => 'CHRIS/CME_S1',
			'Steel' => 'LME/PR_FM',
			'Sugar' => 'CHRIS/ICE_SB1',
			'Sulfur' => '',	
			'Tallow' => '',	
			'Tea' => 'ODA/PTEA_USD',
			'Tin' => 'LME/PR_TN',
			'Titanium' => '',	
			'Tobacco' => 'WORLDBANK/WLD_TOBAC_US',
			'Tungsten' => '',	
			'Turkeys' => '',	
			'Uranium' => '',	
			'Vanadium' => '',	
			'Vegetables' => '',	
			'Wheat' => 'CHRIS/CME_W1',
			'Wool' => 'ODA/PWOOLC_USD',
			'Zinc' => 'LME/PR_ZI',
		]);

		$commodities_codes->each(function($quandl_code, $type) {
				
			$commodity = Commodity::create([
				'name' => $type,
				'slug' => strtolower(str_replace(' ', '-', $type)),
				'quandl_code' => $quandl_code,
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
		});
	}
}
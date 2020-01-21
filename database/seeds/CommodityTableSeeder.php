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
            'Aluminum' => ['code' => 'ODA/PALUM_USD', 'source' => 'quandl'],
            'Antimony' => ['code' => '', 'source' => ''],
            'Bananas' => ['code' => 'ODA/PBANSOP_USD', 'source' => 'quandl'],
            'Barley' => ['code' => 'WORLDBANK/WLD_BARLEY', 'source' => 'quandl'],
            'Bauxite' => ['code' => '', 'source' => ''],
            'Bismuth' => ['code' => '', 'source' => ''],
            'Butter' => ['code' => '', 'source' => ''],
            'Brent Oil' => ['code' => 'CHRIS/ICE_B1', 'source' => 'quandl'],
            'Cadmium' => ['code' => '', 'source' => ''],
            'Cattle' => ['code' => 'ODA/PBEEF_USD', 'source' => 'quandl'],
            'Chromium' => ['code' => '', 'source' => ''],
            'Coal' => ['code' => 'EPI/152', 'source' => 'quandl'],
            'Cobalt' => ['code' => 'LME/PR_CO', 'source' => 'quandl'],
            'Cocoa' => ['code' => 'CHRIS/ICE_CC1', 'source' => 'quandl'],
            'Coffee' => ['code' => 'CHRIS/ICE_KC1', 'source' => 'quandl'],
            'Copper' => ['code' => 'ODA/PCOPP_USD', 'source' => 'quandl'],
            'Corn' => ['code' => 'CHRIS/CME_C1', 'source' => 'quandl'],
            'Corn Oil' => ['code' => '', 'source' => ''],
            'Cotton' => ['code' => 'CHRIS/ICE_CT1', 'source' => 'quandl'],
            'Cottonseed' => ['code' => '', 'source' => ''],
            'Crude Oil' => ['code' => 'CHRIS/CME_CL1', 'source' => 'quandl'],
            'Diamonds' => ['code' => '', 'source' => ''],
            'Eggs' => ['code' => '', 'source' => ''],
            'Electric Power' => ['code' => '', 'source' => ''],
            'Ethanol' => ['code' => '', 'source' => ''],
            'Fish' => ['code' => 'ODA/PFISH_USD', 'source' => 'quandl'],
            'Flaxseed' => ['code' => '', 'source' => ''],
            'Linseed Oil' => ['code' => '', 'source' => ''],
            'Fruits' => ['code' => '', 'source' => ''],
            'Gas' => ['code' => '', 'source' => ''],
            'Gasoline' => ['code' => 'CHRIS/CME_RB1', 'source' => 'quandl'],
            'Gold' => ['code' => 'CME_GC1', 'source' => 'quandl'],
            'Grain Sorghum' => ['code' => '', 'source' => ''],
            'Hay' => ['code' => '', 'source' => ''],
            'Heating Oil' => ['code' => '', 'source' => ''],
            'Hides' => ['code' => 'ODA/PHIDE_USD', 'source' => 'quandl'],
            'Leather' => ['code' => '', 'source' => ''],
            'Hogs' => ['code' => 'CHRIS/CME_LN1', 'source' => 'quandl'],
            'Honey' => ['code' => '', 'source' => ''],
            'Iridium' => ['code' => 'JOHNMATT/IRID', 'source' => 'quandl'],
            'Iron Ore' => ['code' => 'ODA/PIORECR_USD', 'source' => 'quandl'],
            'Lard' => ['code' => 'ODA/PLAMB_USD', 'source' => 'quandl'],
            'Lead' => ['code' => 'LME/PR_PB', 'source' => 'quandl'],
            'Lumber' => ['code' => 'CHRIS/CME_LB1LME/PR_PB', 'source' => 'quandl'],
            'Magnesium' => ['code' => '', 'source' => ''],
            'Manganese' => ['code' => '', 'source' => ''],
            'Mercury' => ['code' => '', 'source' => ''],
            'Milk' => ['code' => 'CHRIS/CME_DA1', 'source' => 'quandl'],
            'Molybdenum' => ['code' => 'LME/PR_MO', 'source' => 'quandl'],
            'Nickel' => ['code' => 'LME/PR_NI', 'source' => 'quandl'],
            'Oats' => ['code' => 'CHRIS/CME_O1', 'source' => 'quandl'],
            'Olive Oil' => ['code' => 'ODA/POLVOIL_USD', 'source' => 'quandl'],
            'Onions' => ['code' => '', 'source' => ''],
            'Oranges' => ['code' => 'ODA/PORANG_USD', 'source' => 'quandl'],
            'Orange Juice' => ['code' => 'CHRIS/ICE_OJ1', 'source' => 'quandl'],
            'Palladium' => ['code' => 'CHRIS/CME_PA1', 'source' => 'quandl'],
            'Palm Oil' => ['code' => 'ODA/PPOIL_USD', 'source' => 'quandl'],
            'Peanuts' => ['code' => 'ODA/PGNUTS_USD', 'source' => 'quandl'],
            'Petroleum' => ['code' => '', 'source' => ''],
            'Plastics' => ['code' => '', 'source' => ''],
            'Platinum' => ['code' => 'CHRIS/CME_PL1', 'source' => 'quandl'],
            'Potatoes' => ['code' => '', 'source' => ''],
            'Poultry' => ['code' => 'ODA/PPOULT_USD', 'source' => 'quandl'],
            'Rapeseed Oil' => ['code' => 'ODA/PROIL_USD', 'source' => 'quandl'],
            'Rhodium' => ['code' => 'JOHNMATT/RHOD', 'source' => 'quandl'],
            'Rice' => ['code' => 'CHRIS/CME_RR1', 'source' => 'quandl'],
            'Ruthenium' => ['code' => 'JOHNMATT/RUTH', 'source' => 'quandl'],
            'Rubber' => ['code' => 'ODA/PRUBB_USD', 'source' => 'quandl'],
            'Salt' => ['code' => '', 'source' => ''],
            'Salmon' => ['code' => 'ODA/PSALM_USD', 'source' => 'quandl'],
            'Shrimp' => ['code' => 'ODA/PSHRI_USD', 'source' => 'quandl'],
            'Silk' => ['code' => '', 'source' => ''],
            'Silver' => ['code' => 'CHRIS/CME_SI1', 'source' => 'quandl'],
            'Soybeans' => ['code' => 'CHRIS/CME_S1', 'source' => 'quandl'],
            'Steel' => ['code' => 'LME/PR_FM', 'source' => 'quandl'],
            'Sugar' => ['code' => 'CHRIS/ICE_SB1', 'source' => 'quandl'],
            'Sulfur' => ['code' => '', 'source' => ''],
            'Tallow' => ['code' => '', 'source' => ''],
            'Tea' => ['code' => 'ODA/PTEA_USD', 'source' => 'quandl'],
            'Tin' => ['code' => 'LME/PR_TN', 'source' => 'quandl'],
            'Titanium' => ['code' => '', 'source' => ''],
            'Tobacco' => ['code' => 'WORLDBANK/WLD_TOBAC_US', 'source' => 'quandl'],
            'Tungsten' => ['code' => '', 'source' => ''],
            'Turkeys' => ['code' => '', 'source' => ''],
            'Uranium' => ['code' => '', 'source' => ''],
            'Vanadium' => ['code' => '', 'source' => ''],
            'Wheat' => ['code' => 'CHRIS/CME_W1', 'source' => 'quandl'],
            'Wool' => ['code' => 'ODA/PWOOLC_USD', 'source' => 'quandl'],
            'Zinc' => ['code' => 'LME/PR_ZI', 'source' => 'quandl']
        ]);

        $commodities_codes->each(function ($data, $type) {			
            $commodity = Commodity::create([
                'name' => $type,
                'slug' => strtolower(str_replace(' ', '-', $type)),
				'code' => collect($data)->get('code'),
				'source' => collect($data)->get('source'),
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

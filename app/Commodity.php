<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'snippets',
        'prices',
        'supply',
        'demand',
        'code',
        'source',
        'status',
    ];

    public $casts = [
        'snippets' => 'json',
        'prices' => 'json',
        'supply' => 'json',
        'demand' => 'json'
    ];

    public function articles()
    {
        return $this->morphMany('App\Article', 'item');
    }

    public function registry()
    {
        return $this->morphOne('App\Registry', 'entry');
    }

    public static $topics = [
        'prices',
        'supply',
        'demand'
    ];

    //All commodities with quandl codes
    public static $codes = [
        'Aluminum' => ['code' => 'ODA/PALUM_USD', 'source' => 'quandl'],
        'Antimony' => ['code' => '', 'source' => ''],
        'Bananas' => ['code' => 'ODA/PBANSOP_USD', 'source' => 'quandl'],
        'Barley' => ['code' => 'ODA/PBARL_USD', 'source' => 'quandl'],
        'Bauxite' => ['code' => '', 'source' => ''],
        'Bismuth' => ['code' => '', 'source' => ''],
        'Bitumen' => ['code' => '', 'source' => ''],
        'Butter' => ['code' => '', 'source' => ''],
        'Brent' => ['code' => 'CHRIS/ICE_B1', 'source' => 'quandl'],
        'Cadmium' => ['code' => '', 'source' => ''],
        'Cheese' => ['code' => '', 'source' => ''],
        'Chromium' => ['code' => '', 'source' => ''],
        'Coal' => ['code' => 'ODA/PCOALAU_USD', 'source' => 'quandl'],
        'Cobalt' => ['code' => '', 'source' => ''],
        'Cocoa' => ['code' => 'CHRIS/ICE_CC1', 'source' => 'quandl'],
        'Coffee' => ['code' => 'CHRIS/ICE_KC1', 'source' => 'quandl'],
        'Copper' => ['code' => 'ODA/PCOPP_USD', 'source' => 'quandl'],
        'Corn' => ['code' => 'CHRIS/CME_C1', 'source' => 'quandl'],
        'Cotton' => ['code' => 'CHRIS/ICE_CT1', 'source' => 'quandl'],
        'Crude Oil' => ['code' => 'CHRIS/CME_CL1', 'source' => 'quandl'],
        'Diamonds' => ['code' => '', 'source' => ''],
        'Eggs' => ['code' => '', 'source' => ''],
        'Electric Power' => ['code' => '', 'source' => ''],
        'Ethanol' => ['code' => '', 'source' => ''],
        'Fish' => ['code' => 'ODA/PFISH_USD', 'source' => 'quandl'],
        'Flaxseed' => ['code' => '', 'source' => ''],
        'Linseed Oil' => ['code' => '', 'source' => ''],
        'Fruits' => ['code' => '', 'source' => ''],
        'Gasoline' => ['code' => 'CHRIS/CME_RB1', 'source' => 'quandl'],
        'Gold' => ['code' => 'CHRIS/CME_GC1', 'source' => 'quandl'],
        'Grain Sorghum' => ['code' => '', 'source' => ''],
        'Hides' => ['code' => 'ODA/PHIDE_USD', 'source' => 'quandl'],
        'Leather' => ['code' => '', 'source' => ''],
        'Honey' => ['code' => '', 'source' => ''],
        'Iridium' => ['code' => 'JOHNMATT/IRID', 'source' => 'quandl'],
        'Iron Ore' => ['code' => 'ODA/PIORECR_USD', 'source' => 'quandl'],
        'Lard' => ['code' => 'ODA/PLAMB_USD', 'source' => 'quandl'],
        'Lead' => ['code' => 'ODA/PLEAD_USD', 'source' => 'quandl'],
        'Lean Hogs' => ['code' => 'CHRIS/CME_LN1', 'source' => 'quandl'],
        'Live Cattle' => ['code' => 'ODA/PBEEF_USD', 'source' => 'quandl'],
        'Lithium' => ['code' => '', 'source' => ''],
        'Lumber' => ['code' => 'CHRIS/CME_LB1', 'source' => 'quandl'],
        'Magnesium' => ['code' => '', 'source' => ''],
        'Manganese' => ['code' => '', 'source' => ''],
        'Mercury' => ['code' => '', 'source' => ''],
        'Milk' => ['code' => 'CHRIS/CME_DA1', 'source' => 'quandl'],
        'Molybdenum' => ['code' => '', 'source' => ''],
        'Neodymium' => ['code' => '', 'source' => ''],
        'Nickel' => ['code' => 'ODA/PNICK_USD', 'source' => 'quandl'],
        'Oat' => ['code' => 'CHRIS/CME_O1', 'source' => 'quandl'],
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
        'Soybean Oil' => ['code' => 'CHRIS/CME_BO1', 'source' => 'quandl'],
        'Steel' => ['code' => 'SHFE/RBV2013', 'source' => 'quandl'],
        'Sugar' => ['code' => 'CHRIS/ICE_SB1', 'source' => 'quandl'],
        'Sulfur' => ['code' => '', 'source' => ''],
        'Tallow' => ['code' => '', 'source' => ''],
        'Tea' => ['code' => 'ODA/PTEA_USD', 'source' => 'quandl'],
        'Tin' => ['code' => 'ODA/PTIN_USD', 'source' => 'quandl'],
        'Titanium' => ['code' => '', 'source' => ''],
        'Tobacco' => ['code' => '', 'source' => ''],
        'Tungsten' => ['code' => '', 'source' => ''],
        'Turkeys' => ['code' => '', 'source' => ''],
        'Uranium' => ['code' => '', 'source' => ''],
        'Vanadium' => ['code' => '', 'source' => ''],
        'Wheat' => ['code' => 'CHRIS/CME_W1', 'source' => 'quandl'],
        'Wool' => ['code' => 'ODA/PWOOLC_USD', 'source' => 'quandl'],
        'Zinc' => ['code' => 'ODA/PZINC_USD', 'source' => 'quandl']
    ];
}

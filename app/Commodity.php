<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [ 
        'name',
        'slug',
        'snippets',
        'spot',
        'historical_prices',
        'supply',        
        'historical_supply',
        'demand',        
        'historical_demand',  
        'status',                
    ];

    public $casts = [        
        'snippets' => 'json', 
        'historical_prices' => 'json', 
        'historical_supply' => 'json', 
        'historical_demand' => 'json'
    ];   

    public function articles()
    {
        return $this->morphMany('App\Article', 'item');
    }

    public function registry()
    {
        return $this->morphOne('App\Registry', 'entry');
    }
}

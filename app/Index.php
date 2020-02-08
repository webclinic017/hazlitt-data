<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    protected $table = 'indices';

    protected $fillable = [
        'country_id',
        'country_name', 
        'name',
        'historical_prices',
        'indicators',        
    ];

    public $casts = [        
        'historical_prices' => 'json', 
        'indicators' => 'json'
    ];  

}

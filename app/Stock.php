<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [        
        'index_id',
        'name',
        'ticker',
        'price',
        'financials',
        'ratios',
        'company',            
    ];

    public $casts = [        
        'financials' => 'json', 
        'ratios' => 'json',
        'company' => 'json'
    ];  
}

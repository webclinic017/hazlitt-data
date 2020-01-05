<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'snippets',                      
        'inflation',            
        'corporate_tax',            
        'interest_rate',            
        'unemployment_rate',            
        'labor_force',            
        'income_tax',            
        'gdp',            
        'gov_debt_to_gdp',            
        'central_bank_balance_sheet',            
        'budget',            
        'status'
    ];

    public $casts = [        
        'snippets' => 'json',     
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

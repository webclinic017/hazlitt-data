<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'slug',
        'snippets',
        'population',
        'gdp',
        'inflation',
        'corporate_tax',
        'interest_rate',
        'income',
        'personal_savings',
        'unemployment_rate',
        'labor_force',
        'income_tax',
        'gov_debt_to_gdp',
        'bank_reserves',
        'budget',
        'status'
    ];

    public $casts = [
        'snippets' => 'json',
        'population' => 'json',
        'inflation' => 'json',
        'corporate_tax' => 'json',
        'interest_rate' => 'json',
        'unemployment_rate' => 'json',
        'labor_force' => 'json',
        'income_tax' => 'json',
        'gdp' => 'json',
        'gov_debt_to_gdp' => 'json',
        'central_bank_balance_sheet' => 'json',
        'budget' => 'json',
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
        'interest-rates',
        'economy',
        'culture'
    ];
}

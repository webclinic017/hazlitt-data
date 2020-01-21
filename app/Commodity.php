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
}

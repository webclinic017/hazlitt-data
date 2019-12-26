<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'id',
        'name',
        'slug',
        'snippets',                              
        'price',           
        'status',                    
    ];

    public $casts = [        
        'snippets' => 'json',     
    ];

    public function articles()
    {
        return $this->hasMany('App\Article', 'commodity_id');
    }

    public function registry()
    {
        return $this->morphOne('App\Registry', 'entry');
    }
}

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
        return $this->morphMany('App\Article', 'item');
    }

    public function registry()
    {
        return $this->morphOne('App\Registry', 'entry');
    }
}

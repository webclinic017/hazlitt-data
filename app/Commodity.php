<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'article_id',
        'name',
        'queries',
        'snippets',
        'price'
    ];

    public $casts = [
        'queries' => 'json',
        'snippets' => 'json',     
    ];

    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function registry()
    {
        return $this->morphOne('App\Registry', 'entry');
    }
}

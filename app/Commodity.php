<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'article_id',
        'name',
        'queries',
        'price'
    ];

    public $casts = [
        'queries' => 'json',     
    ];

    public function articles()
    {
        return $this->hasOne('App\Article');
    }

    public function registry()
    {
        return $this->morphOne('App\Registry', 'entry');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'news_id',
        'name',
        'queries',
        'price'
    ];

    public $casts = [
        'queries' => 'json',     
    ];

    public function news()
    {
        return $this->hasOne('App\News');
    }
}

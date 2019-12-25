<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Article extends Model
{
    protected $fillable = [
        'source',
        'headline',
        'release_date',
        'category',
        'url',
        'commodity_id'
    ];

    public function commodities()
    {
        return $this->belongsTo('App\Commodity', 'commodity_id');
    }

    public function countries()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class News extends Model
{
    protected $fillable = [
        'source',
        'headline',
        'release_date',
        'url',
        'commodity_id'
    ];

    public function commodities()
    {
        return $this->belongsTo('App\Commodity');
    }
}

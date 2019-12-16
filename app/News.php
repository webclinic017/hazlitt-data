<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class News extends Model
{
    protected $fillable = [
        'source',
        'headline',
        'date-released',
        'url'
    ];

    public function commodities()
    {
        return $this->belongsTo('App\Commodity');
    }
}

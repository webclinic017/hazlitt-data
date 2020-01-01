<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Article extends Model
{
    protected $fillable = [
    'commodity_id',
    'country_id',
    'source',
    'url',
    'headline',
    'type',
    'category',
    'release_date',
    ];

    public function entry()
    {
        return $this->morphTo();
    }
}

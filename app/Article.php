<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Article extends Model
{
    protected $fillable = [
    'item_id',
    'item_type',
    'source',
    'url',
    'headline',
    'subject',
    'topic',
    'release_date',
    ];

    public function entry()
    {
        return $this->morphTo();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Article extends Model
{
    protected $fillable = [
    'entry_id',
    'entry_type',
    'source',
    'url',
    'headline',
    'item',
    'subject',
    'release_date',
    ];

    public function entry()
    {
        return $this->morphTo();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
    protected $table = 'registry';

    protected $fillable = [
        'url',
        'destination',
        'request',
        'layout',
        'view',        
        'redirect',
        'code',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_robots',
    ];

    public function entry()
    {
        return $this->morphTo();
    }
}

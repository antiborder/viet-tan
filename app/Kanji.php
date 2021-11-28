<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Kanji extends Model
{
    protected $fillable = [
        'name',
    ];

    public function words(): hasMany
    {
        return $this->hasMany('App\Word', 'name');
    }
    //==========ここまで追加==========
}




<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'keywords',
    ];

    public function words(): BelongsToMany
    {
        return $this->belongsToMany('App\Word','word_tag')->withTimestamps();
    }    
}

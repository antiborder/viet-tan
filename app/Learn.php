<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Learn extends Model
{
    protected $fillable = [
        'user_id',
        'word_id',
        'result',
        'easiness',
        'next_time',
        'progress',
        'progress_MF',
        'next_mode',
    ];
}

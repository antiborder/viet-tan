<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Word extends Model
{
    protected $fillable = [
        'name',
        'name0',
        'name1',
        'name2',
        'name3',
        'name4',
        'name5',
        'name6',
        'name7',
        'kanji0',
        'kanji1',
        'kanji2',
        'kanji3',
        'kanji4',
        'kanji5',
        'kanji6',
        'kanji7',        
        'jp',
        'detail',
        'level',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Tag', 'word_tag')->withTimestamps();
    }

    public function syno_followers(): BelongsToMany
    {
        return $this->belongsToMany('App\Word', 'synonym', 'followee_name', 'follower_name', 'name', 'name')->withTimestamps();
    }

    public function syno_followings(): BelongsToMany
    {
        return $this->belongsToMany('App\Word', 'synonym', 'follower_name', 'followee_name', 'name', 'name')->withTimestamps();
    }    

    public function anto_followers(): BelongsToMany
    {
        return $this->belongsToMany('App\Word', 'antonym', 'followee_name', 'follower_name', 'name', 'name')->withTimestamps();
    }

    public function anto_followings(): BelongsToMany
    {
        return $this->belongsToMany('App\Word', 'antonym', 'follower_name', 'followee_name', 'name', 'name')->withTimestamps();
    }        

    public function synonyms()
    {
        $followings = $this->syno_followings;
        $followers = $this->syno_followers;
        return $followings->merge($followers)->sortBy('level');
    }

    public function antonyms()
    {
        $followings = $this->anto_followings;
        $followers = $this->anto_followers;
        return $followings->merge($followers)->sortBy('level');
    }    
    public function randomWord():Word
    {
        $word = Word::inRandomOrder()->first();
        return $word;
    }   
}

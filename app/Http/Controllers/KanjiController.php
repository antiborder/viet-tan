<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kanji;
use App\Word;

class KanjiController extends Controller
{
    public function show(string $name)
    {
        $kanji = Kanji::where('name', $name) -> first();
        $words = Word::where('kanji0',$name);
        for($i=1;$i<8;$i++){
            $words = $this->kanji_filter($words, $name, $i);
        }
        $words = $words ->get();

        return view('kanjis.show', ['kanji' => $kanji, 'words' => $words]);
    }

    public function kanji_filter($words, $name, $i){
        $kanji_n = "kanji" . $i;        
        return $words -> Orwhere($kanji_n, $name);
    }
}

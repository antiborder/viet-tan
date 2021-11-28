<?php

namespace App\Http\Controllers;

use App\Word;
use App\Tag;
use App\Kanji;
use App\Http\Requests\WordRequest;
use Illuminate\Http\Request;

class WordController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Word::class, 'word');
    }

    public function index()
    {

        $words = Word::all()->sortByDesc('created_at');

        return view('words.index', ['words' => $words]);
    }    

    public function create()
    {

        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        $synonyms = [];
        for($i=0; $i<5; $i++){
            $synonyms[] = "";
        }
        $antonyms = [];
        for($i=0; $i<5; $i++){
            $antonyms[] = "";
        }        

        return view('words.create', [
            'allTagNames' => $allTagNames,
            'synonyms' => $synonyms,
            'antonyms' => $antonyms,
        ]);
    }

    public function store(WordRequest $request, Word $word)
    {
        $word->fill($request->all());
   
        for($i=0; $i<8; $i++){
            $kanji_n = "kanji" . $i;
            if($word->$kanji_n !=""){
                $kanji = Kanji::firstOrCreate([
                    'name' => $word->$kanji_n
                ], [
                    'name' => $word->$kanji_n,
                ]);
            }
        }

        for($i=0; $i<count($request->name); $i++){
            $name_n = "name" . $i;
            $word->$name_n = $request->name[$i];
        }        
        $word->user_id = $request->user()->id;
        $word->save();

        $request->tags->each(function ($tagName) use ($word) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $word->tags()->attach($tag);
        });

        return redirect()->route('words.index');
    }
    public function edit(Word $word)
    {
        $tagNames = $word->tags->map(function ($tag) {
            return ['text' => $tag->name];
        });
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        $synonyms = [];
        for($i=0; $i<5; $i++){
            $synonym= $word->synonyms()->get($i);
            if($synonym !== null){
                $synonyms[] = $synonym->name;
            }else{
                $synonyms[] = "";
            }
        }
        $antonyms = [];
        for($i=0; $i<5; $i++){
            $antonym= $word->antonyms()->get($i);
            if($antonym !== null){
                $antonyms[] = $antonym->name;
            }else{
                $antonyms[] = "";
            }
        }        
        return view('words.edit', [
            'word' => $word,
            'tagNames' => $tagNames,
            'allTagNames' => $allTagNames,    
            'synonyms' => $synonyms,        
            'antonyms' => $antonyms,
        ]);
    }

    public function update(WordRequest $request, Word $word)
    {
        $word->fill($request->all());

        //word
        for($i=0; $i<8; $i++){
            $kanji_n = "kanji" . $i;
            if($word->$kanji_n !=""){
                $kanji = Kanji::firstOrCreate([
                    'name' => $word->$kanji_n
                ], [
                    'name' => $word->$kanji_n,
                ]);
            }
        }

        for($i=0; $i<count($request->name); $i++){
            $name_n = "name" . $i;
            $word->$name_n = $request->name[$i];
        }
        $word->save();

        //tag
        $word->tags()->detach();
        $request->tags->each(function ($tagName) use ($word) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $word->tags()->attach($tag);
        });

        //synonym
        $word -> syno_followings() -> detach();        
        $word -> syno_followers() -> detach();        
        for($i=0;$i<5;$i++){
            $synonym_n = "synonym" . $i;
            if($request->$synonym_n != '')
            {
                $synonym = Word::firstOrCreate([ 'name' => $request->$synonym_n]);
                if($word->id > $synonym->id){
                    $word->syno_followings()->attach($synonym);                    
                }else if($word->id < $synonym->id){
                    $word->syno_followers()->attach($synonym);                    
                }                
            }
        }

        //antonym
        $word -> anto_followings() -> detach();        
        $word -> anto_followers() -> detach();        
        for($i=0;$i<5;$i++){
            $antonym_n = "antonym" . $i;
            if($request->$antonym_n != '')
            {
                $antonym = Word::firstOrCreate([ 'name' => $request->$antonym_n]);
                if($word->id > $antonym->id){
                    $word->anto_followings()->attach($antonym);                    
                }else if($word->id < $antonym->id){
                    $word->anto_followers()->attach($antonym);                    
                }                
            }
        }


        return redirect()->route('words.index');
    }
    public function destroy(Word $word)
    {
        $word->delete();
        return redirect()->route('words.index');
    }
    public function show(Word $word)
    {
        $target_words = Word::all();        
        $common_syllables = [];
        for($m=0; $m<8; $m++){
            for($n=0; $n<8; $n++){            
                $name_n = 'name' . $n;
                if($word->$name_n !== null){
                    $addition = $target_words->where('name' . $m, $word->$name_n)->Where('name', '!==', $word->name)->all();
                    $common_syllables = array_merge($common_syllables, $addition);
                }
            }
        }    
        $common_syllables = array_unique($common_syllables);        
        return view('words.show', ['word' => $word, 'common_syllables' => $common_syllables]);
    }   
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $query_name = Word::query();
        $query_jp = Word::query();
        $query_kanji = Word::query();
        $query_tag = Tag::query();

        if(!empty($keyword)){
            $query_name->where('name','like','%'.$keyword.'%');
            $query_jp->where('jp','like','%'.$keyword.'%');
            $query_kanji->where('kanji0','like','%'.$keyword.'%');
                for($i=1;$i<8;$i++){
                    $query_kanji->orWhere('kanji'. $i, 'like', '%'.$keyword.'%');
                }
            $query_tag->where('name','like','%'.$keyword.'%');

            $words_name = $query_name->paginate(20);
            $words_jp = $query_jp->paginate(20);        
            $words_kanji = $query_kanji->paginate(20);        
            $tags = $query_tag->paginate(20);           
            $msg = '「' . $keyword . '」の検索結果';  
        }else{
            $words_name = [];
            $words_jp = [];
            $words_kanji = [];
            $tags = [];
            $msg = '検索キーワードを入力してください。';
        }
        
        return view('words.search')->with('keyword',$keyword)->with('words_name',$words_name)->with('words_jp',$words_jp)->with('words_kanji',$words_kanji)->with('tags',$tags)->with('msg', $msg);

    }
    // public function name_filter($word, $target_words, int $m, int $n){
    //     $name_n = 'name' . $n;
    //     $target_words = $target_words->orWhere('name' . $m , $word->$name_n);
    //     return $target_words;
    // }
}
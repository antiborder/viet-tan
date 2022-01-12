<?php

namespace App\Http\Controllers;

use App\Word;
use App\Tag;
use App\Kanji;
use App\Http\Requests\WordRequest;
use Illuminate\Http\Request;

use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;

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
   
        //name
        $exploded = explode(' ', $word->name, 8);
        for($i=0; $i<count($exploded); $i++){
            $name_n = "name" . $i;
            $word->$name_n = $exploded[$i];
        }                

        //kanji
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

        $word->user_id = $request->user()->id;
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
                $synonym = Word::where('name',$request->$synonym_n)->first();
                if(empty($synonym)){
                    $synonym = new Word();
                    $synonym->fill(['name' => $request->$synonym_n]);
                    $syllables = explode(' ', $request->$synonym_n, 8);
                    foreach($syllables as $index => $syllable){
                        $synonym->fill(['name'.$index => $syllable]);
                    }
                    $synonym->user_id = $request->user()->id;                    
                    $synonym->save();
                } 
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
                $antonym = Word::where('name',$request->$antonym_n)->first();
                if(empty($antonym)){
                    $antonym = new Word();
                    $antonym->fill(['name' => $request->$antonym_n]);
                    $syllables = explode(' ', $request->$antonym_n, 8);
                    foreach($syllables as $index => $syllable){
                        $antonym->fill(['name'.$index => $syllable]);
                    }
                    $antonym->user_id = $request->user()->id;                    
                    $antonym->save();
                } 
                if($word->id > $antonym->id){
                    $word->anto_followings()->attach($antonym);                    
                }else if($word->id < $antonym->id){
                    $word->anto_followers()->attach($antonym);                    
                }                
            }
        }

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

        //name
        $exploded = explode(' ', $word->name, 8);
        for($i=0; $i<count($exploded); $i++){
            $name_n = "name" . $i;
            $word->$name_n = $exploded[$i];
        }                

        //kanji
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

        $word->user_id = $request->user()->id;
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
                $synonym = Word::where('name',$request->$synonym_n)->first();
                if(empty($synonym)){
                    $synonym = new Word();
                    $synonym->fill(['name' => $request->$synonym_n]);
                    $syllables = explode(' ', $request->$synonym_n, 8);
                    foreach($syllables as $index => $syllable){
                        $synonym->fill(['name'.$index => $syllable]);
                    }
                    $synonym->user_id = $request->user()->id;                    
                    $synonym->save();
                } 
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
                $antonym = Word::where('name',$request->$antonym_n)->first();
                if(empty($antonym)){
                    $antonym = new Word();
                    $antonym->fill(['name' => $request->$antonym_n]);
                    $syllables = explode(' ', $request->$antonym_n, 8);
                    foreach($syllables as $index => $syllable){
                        $antonym->fill(['name'.$index => $syllable]);
                    }
                    $antonym->user_id = $request->user()->id;                    
                    $antonym->save();
                } 
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

    public function choose(){
        return view('choose');
    }

    public function import(Request $request)
    {
        // return redirect('/')->with('flash_message', $request->file('file'));
        // CSV ファイル保存
        $tmpName = mt_rand().".".$request->file('file')->guessExtension(); //TMPファイル名
        $request->file('file')->move(public_path()."/csv/tmp",$tmpName);
        $tmpPath = public_path()."/csv/tmp/".$tmpName;
     
        //Goodby CSVのconfig設定
        $config = new LexerConfig();
        $interpreter = new Interpreter();
        $lexer = new Lexer($config);
     
        //CharsetをUTF-8に変換、CSVのヘッダー行を無視
        $config->setToCharset("UTF-8");
        $config->setFromCharset("UTF-8");
        $config->setIgnoreHeaderLine(true);
      
        $dataList = [];
         
        // 新規Observerとして、$dataList配列に値を代入
        $interpreter->addObserver(function (array $row) use (&$dataList){
            // 各列のデータを取得
            $dataList[] = $row;
        });
     
        // CSVデータをパース
        $lexer->parse($tmpPath, $interpreter);
     
        // TMPファイル削除
        unlink($tmpPath);
     
        // 登録処理
        $count = 0;
        foreach($dataList as $row){
            $word = Word::firstOrNew(['name' => $row[0]]);
            $word->fill([
                'jp' => $row[1],
                'level' => $row[10]
            ]);

            //name            
            $exploded = explode(' ', $word->name, 8);
            for($i=0; $i<count($exploded); $i++){
                $name_n = "name" . $i;
                $word->fill([$name_n => $exploded[$i]]);
            }

            //kanji
            for($i=0; $i<8; $i++){
                $kanji_n = "kanji" . $i;
                if( ($row[2+$i]!=="") && ($row[2+$i]!=="　") ){
                    $word->fill( [$kanji_n => $row[2+$i]] );                                
                    }
                if($word->$kanji_n !=""){
                    $kanji = Kanji::firstOrCreate([
                        'name' => $word->$kanji_n
                    ], [
                        'name' => $word->$kanji_n,
                    ]);
                }
            }
            $word->user_id = $request->user()->id;
            $word->save();

            //tag
            $tagNames = explode(' ', $row[11],5);
            $word->tags()->detach();
            foreach($tagNames as $tagName){
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $word->tags()->attach($tag);
            }    

            //synonym
            $word -> syno_followings() -> detach();        
            $word -> syno_followers() -> detach();        
            for($i=0;$i<5;$i++){
                $synonym_n = "synonym" . $i;
                $synonym_name = $row[13 + $i];
                if($synonym_name != '')
                {
                    $synonym = Word::where('name',$synonym_name)->first();
                    if(empty($synonym)){
                        $synonym = new Word();
                        $synonym->fill(['name' => $synonym_name]);
                        $syllables = explode(' ', $synonym_name, 8);
                        foreach($syllables as $i => $syllable){
                            $synonym->fill(['name'.$i => $syllable]);
                        }
                        $synonym->user_id = $request->user()->id;                    
                        $synonym->save();
                    } 
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
                $antonym_name = $row[18 + $i];
                if($antonym_name != '')
                {
                    $antonym = Word::where('name',$antonym_name)->first();
                    if(empty($antonym)){
                        $antonym = new Word();
                        $antonym->fill(['name' => $antonym_name]);
                        $syllables = explode(' ', $antonym_name, 8);
                        foreach($syllables as $i => $syllable){
                            $antonym->fill(['name'.$i => $syllable]);
                        }
                        $antonym->user_id = $request->user()->id;                    
                        $antonym->save();
                    } 
                    if($word->id > $antonym->id){
                        $word->anto_followings()->attach($antonym);                    
                    }else if($word->id < $antonym->id){
                        $word->anto_followers()->attach($antonym);                    
                    }                
                }
            }            
            $count++;
        }        
     
        return redirect()->action('WordController@index')->with('flash_message', $count . '冊の本を登録しました！');
    }

    // public function learn(Request $request)
    // {    
    //     return view('words.learn');
    // }

    public function learn()
    {

        // $words = Word::inRandomOrder()->take(4)->get();

        return view('words.learn');
    }
    
    public function random()
    {
        $answer = Word::inRandomOrder()->first();
        $others = Word::inRandomOrder()->take(3)->get();
        return [
            'answer' => $this->formatWord($answer),
            'others' =>[
                $this->formatWord($others[0]),
                $this->formatWord($others[1]),
                $this->formatWord($others[2]),                                
            ],
        ];
    }    

    public function formatWord(Word $word){
        return [
            'syllables'=>[
                $word->name0,
                $word->name1,
                $word->name2,
                $word->name3,
                $word->name4,
                $word->name5,
                $word->name6,
                $word->name7
            ],
            'kanjis'=>[
                $word->kanji0,
                $word->kanji1,
                $word->kanji2,
                $word->kanji3,
                $word->kanji4,
                $word->kanji5,
                $word->kanji6,
                $word->kanji7
            ],               
            'jp'=>$word->jp,
            'level'=>$word->level,
            'id'=>$word->id,
        ];
    }
}
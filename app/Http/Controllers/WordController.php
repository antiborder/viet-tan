<?php

namespace App\Http\Controllers;

use DB;
use App\Word;
use App\Tag;
use App\Kanji;
use App\User;
use App\Http\Requests\WordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('index');
    }    

    public function level(int $level = null)
    {
        if( $level === null ){
            $level = 1;
        }
        $words = Word::all()->where('level',$level)->sortByDesc('created_at');
        return view('words.level', ['words' => $words, 'count' => $words->count()]);
    }    

    public function create()
    {

        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        $synonyms = [];
        for($i=0; $i<config('const.SYNONYM_MAX'); $i++){
            $synonyms[] = "";
        }
        $antonyms = [];
        for($i=0; $i<config('const.ANTONYM_MAX'); $i++){
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

        //no-diacritic
        $no_diacritic = $this->simplify_vowel($word->name);
        $no_diacritic = str_replace('đ','d',$no_diacritic);        
        $no_diacritic = mb_strtolower($no_diacritic, "UTF-8");
        $word->fill(['no_diacritic' => $no_diacritic]);

        //simplified
        $simplified = $this->simplify_word($word->no_diacritic);
        $simplified = mb_strtoupper($simplified, "UTF-8");
        $word->fill(['simplified' => $simplified]);        

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
        for($i=0;$i<config('const.SYNONYM_MAX');$i++){
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
        for($i=0;$i<config('const.ANTONYM_MAX');$i++){
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

        return redirect()->route('index');
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
        for($i=0; $i<config('const.SYNONYM_MAX'); $i++){
            $synonym= $word->synonyms()->get($i);
            if($synonym !== null){
                $synonyms[] = $synonym->name;
            }else{
                $synonyms[] = "";
            }
        }
        $antonyms = [];
        for($i=0; $i<config('const.ANTONYM_MAX'); $i++){
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

        //no-diacritic
        $no_diacritic = $this->simplify_vowel($word->name);
        $no_diacritic = str_replace('đ','d',$no_diacritic);        
        $no_diacritic = mb_strtolower($no_diacritic, "UTF-8");
        $word->fill(['no_diacritic' => $no_diacritic]);

        //simplified
        $simplified = $this->simplify_word($word->no_diacritic);
        $simplified = mb_strtoupper($simplified, "UTF-8");
        $word->fill(['simplified' => $simplified]);                

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
        for($i=0;$i<config('const.SYNONYM_MAX');$i++){
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
        for($i=0;$i<config('const.ANTONYM_MAX');$i++){
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

        return redirect()->route('index');
    }
    public function destroy(Word $word)
    {
        $word->delete();
        return redirect()->route('index');
    }
    public function show(Word $word)
    {
        $target_words = Word::all();        
        $common_syllables = collect([]);
        for($m=0; $m<8; $m++){
            for($n=0; $n<8; $n++){            
                $name_n = 'name' . $n;
                if($word->$name_n !== null){
                    $addition = Word::all()->where('name' . $m, $word->$name_n)->Where('name', '!==', $word->name);
                    $common_syllables = $common_syllables->merge($addition);
                }
            }
        }
        $common_syllables = $common_syllables->unique()->sortBy('level');

        $subscription = User::getSubscription();
        $similar_pronuciations = Word::all()->where('no_diacritic', $word->no_diacritic)->where('name', '!==', $word->name)->sortBy('level');//->all()        

        return view('words.show', ['word' => $word, 'common_syllables' => $common_syllables, 'similar_pronuciations' => $similar_pronuciations, 'subscription'=>$subscription]);
    }   
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $keyword = preg_replace("/　|・|「|」|、|。|,|\.|:|;|\/|\\|／|￥/"," ",$keyword);

        //keyword有無を判定
        if(strlen(str_replace(" ","",$keyword)) > 0){

            //完全一致
            $query_name_exact = Word::where('name', $keyword);
            $exact_list = $this->get_name_list($query_name_exact);
            $words_name_exact = $query_name_exact->paginate(20)->sortBy('level');

            //だいたい同じ
            $query_name_similar = Word::where('no_diacritic',mb_strtolower($this->simplify_vowel($keyword)))->whereNotIn('name', $exact_list);
            $words_name_similar = $query_name_similar->paginate(20)->sortBy('level');            
            $similar_list = array_merge($exact_list, $this->get_name_list($query_name_similar));
            
            //なんか似てる
            $query_name_simplified = Word::where('simplified',mb_strtoupper($this->simplify_word($this->simplify_vowel($keyword))))->whereNotIn('name',$exact_list)->whereNotIn('name',$similar_list);
            $words_name_simplified = $query_name_simplified->paginate(20)->sortBy('level');
            $simplified_list = array_merge($similar_list, $this->get_name_list($query_name_simplified));

            //音節が一致
            $keyword_syllables = explode(' ', $keyword, 5);
            $query_name_syllables = Word::where(function($query) use ($keyword_syllables) {
                foreach($keyword_syllables as $keyword_syllable){
                    for($n=0; $n<8; $n++){
                        $name_n = 'name' . $n;                    
                        $query->Orwhere($name_n, $keyword_syllable);
                    }
                }
            });
            $query_name_syllables = $query_name_syllables->whereNotIn('name',$exact_list)->whereNotIn('name',$similar_list)->whereNotIn('name',$simplified_list);
            $words_name_syllables = $query_name_syllables->paginate(20)->sortBy('level');

            //意味が該当
            $query_jp = Word::where('jp','like','%'.$keyword.'%');
            $words_jp = $query_jp->paginate(20)->sortBy('level');

            //漢字が該当
            $query_kanji = Word::where('kanji0','like','%'.$keyword.'%');
                for($i=1;$i<8;$i++){
                    $query_kanji->orWhere('kanji'. $i, 'like', '%'.$keyword.'%');
                }
            $words_kanji = $query_kanji->paginate(20)->sortBy('level');        

            //タグが該当
            $query_tag = Tag::where('name','like','%'.$keyword.'%');
            $tags = $query_tag->paginate(20);           
            
            $title = $keyword . 'の検索結果';

            //該当無しを判定
            if(count($words_name_exact) === 0 &&
            count($words_name_similar) === 0 &&
            count($words_name_simplified) === 0 &&
            count($words_name_syllables) === 0 &&
            count($words_jp) === 0 &&
            count($words_kanji) === 0
            ){
                $msg = '検索条件「' . $keyword . '」に該当する情報はありませんでした。';
                $result = "FAIL";
            }else{
                $msg = '「' . $keyword . '」の検索結果';  
                $result = "SUCCESS";
            }
        }else{
            $result = 'FAIL';
            $words_name_exact = [];
            $words_name_similar = [];
            $words_name_simplified = [];
            $words_name_syllables = [];
            $words_jp = [];
            $words_kanji = [];
            $tags = [];
            $msg = '';
            $title = "あいまい検索";

        }
        
        return view('words.search')->with('keyword',$keyword)->
        with('words_name_exact',$words_name_exact)->
        with('words_name_similar',$words_name_similar)->
        with('words_name_simplified',$words_name_simplified)->
        with('words_name_syllables',$words_name_syllables)->
        with('words_jp',$words_jp)->
        with('words_kanji',$words_kanji)->
        with('tags',$tags)->with('msg', $msg)->with('title', $title)->
        with('result',$result);

    }

    public function get_name_list($query_name) {
        $name_list = array_map(
            function ($element) { 
                return $element['name']; 
            },
            $query_name->get()->toArray()
        );
        return $name_list;
    }

    public function choose(){
        return view('choose');
    }

    public function import(Request $request)
    {
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
            if($row[0]===''){
            break;
            }
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

            //no-diacritic
            $no_diacritic = $this->simplify_vowel($word->name);
            $no_diacritic = str_replace('đ','d',$no_diacritic);        
            $no_diacritic = mb_strtolower($no_diacritic, "UTF-8");
            $word->fill(['no_diacritic' => $no_diacritic]);

            //simplified
            $simplified = $this->simplify_word($word->no_diacritic);
            $simplified = mb_strtoupper($simplified, "UTF-8");
            $word->fill(['simplified' => $simplified]);                    

            //kanji
            for($i=0; $i<8; $i++){

                $kanji_n = "kanji" . $i;
                if( ($row[2+$i]=="") || ($row[2+$i]=="　") ){
                    // $word->fill( [$kanji_n => ''] );                                                                        
                }else{
                    $word->fill( [$kanji_n => $row[2+$i]] );                                

                    $kanji = Kanji::firstOrCreate([
                        'name' => $word->$kanji_n
                    ], [
                        'name' => $word->$kanji_n,
                    ]);
                }
                if($word->$kanji_n !=""){

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
            for($i=0;$i<config('const.SYNONYM_MAX');$i++){
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
            for($i=0;$i<config('const.ANTONYM_MAX');$i++){
                $antonym_n = "antonym" . $i;
                $antonym_name = $row[ 13+config('const.SYNONYM_MAX') + $i];
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
            if($word->level !== null){            
                $count++;
            }
        }

        $words = Word::whereNull('level')->get();
        foreach($words as $word){
            $word->delete();
        }

        return redirect()->action('WordController@index')->with('flash_message', '単語を' . $count . '個登録しました！');
    }

    public function export_words(Request $request){
        $task = new Word;
        $table = $task->getTable();
        $columns = $task->getConnection()->getSchemaBuilder()->getColumnListing($table);
        $header = collect($columns)->implode(",");
        // return $header;
        $selectStr = collect($columns)->map(function($item) {
            return $item;//"ifnull({$item}, '')";            
        })->implode(", ',' ,");

        $words = DB::table('words')
        ->select(DB::raw("concat({$selectStr}) as record"))
         ->pluck("record");
        // ヘッダーとデータを加えて改行コードでつなげて１つの文字列にする
        $text = $words->prepend($header)->implode("\r\n");
        $text = str_replace(array("\n"), ' ', $text);

        return $text;

    }    
    public function export_tags(Request $request){
        $task = new Tag;
        $table = $task->getTable();
        $columns = $task->getConnection()->getSchemaBuilder()->getColumnListing($table);
        $header = collect($columns)->implode(",");
        // return $header;
        $selectStr = collect($columns)->map(function($item) {
            return $item;//"ifnull({$item}, '')";            
        })->implode(", ',' ,");
        

        $data = DB::table('tags')
        ->select(DB::raw("concat({$selectStr}) as record"))
         ->pluck("record");
        // ヘッダーとデータを加えて改行コードでつなげて１つの文字列にする
        $text = $data->prepend($header)->implode("\r\n");
        $text = str_replace(array("\n"), ' ', $text);

        return $text;

    }        

    public function clear(Request $request)
    {
        
        $words = Word::all();
        foreach($words as $word){
            $word->delete();
        }
        return redirect()->action('WordController@index')->with('flash_message', '単語を全て削除しました！');
    }

    public function trim(Request $request)
    {
        $words = Word::whereNull('level')->get();
        foreach($words as $word){
            $word->delete();
        }
        return redirect()->action('WordController@index')->with('flash_message', 'level未登録の単語を削除しました！');
    }    

    
    public function simplify_vowel($str){

        $str = str_replace('ã','a',$str);
        $str = str_replace('á','a',$str);
        $str = str_replace('ả','a',$str);
        $str = str_replace('à','a',$str);
        $str = str_replace('ạ','a',$str);

        $str = str_replace('ă','a',$str);        
        $str = str_replace('ẵ','a',$str);
        $str = str_replace('ắ','a',$str);
        $str = str_replace('ẳ','a',$str);
        $str = str_replace('ằ','a',$str);
        $str = str_replace('ặ','a',$str);        

        $str = str_replace('â','a',$str);        
        $str = str_replace('ẫ','a',$str);
        $str = str_replace('ấ','a',$str);
        $str = str_replace('ẩ','a',$str);
        $str = str_replace('ầ','a',$str);
        $str = str_replace('ậ','a',$str);
        
        $str = str_replace('ĩ','i',$str);
        $str = str_replace('í','i',$str);
        $str = str_replace('ỉ','i',$str);
        $str = str_replace('ì','i',$str);
        $str = str_replace('ị','i',$str);

        $str = str_replace('y','i',$str);
        $str = str_replace('ỹ','i',$str);
        $str = str_replace('ý','i',$str);
        $str = str_replace('ỷ','i',$str);
        $str = str_replace('ỳ','i',$str);
        $str = str_replace('ỵ','i',$str);        

        $str = str_replace('ũ','u',$str);
        $str = str_replace('ú','u',$str);
        $str = str_replace('ủ','u',$str);
        $str = str_replace('ù','u',$str);
        $str = str_replace('ụ','u',$str);

        $str = str_replace('ư','u',$str);        
        $str = str_replace('ữ','u',$str);
        $str = str_replace('ứ','u',$str);
        $str = str_replace('ử','u',$str);
        $str = str_replace('ừ','u',$str);
        $str = str_replace('ự','u',$str);

        $str = str_replace('ẽ','e',$str);
        $str = str_replace('é','e',$str);
        $str = str_replace('ẻ','e',$str);
        $str = str_replace('è','e',$str);
        $str = str_replace('ẹ','e',$str);

        $str = str_replace('ê','e',$str);
        $str = str_replace('ễ','e',$str);
        $str = str_replace('ế','e',$str);
        $str = str_replace('ể','e',$str);
        $str = str_replace('ề','e',$str);
        $str = str_replace('ệ','e',$str);

        $str = str_replace('õ','o',$str);
        $str = str_replace('ó','o',$str);
        $str = str_replace('ỏ','o',$str);
        $str = str_replace('ò','o',$str);
        $str = str_replace('ọ','o',$str);

        $str = str_replace('ô','o',$str);
        $str = str_replace('ỗ','o',$str);
        $str = str_replace('ố','o',$str);
        $str = str_replace('ổ','o',$str);
        $str = str_replace('ồ','o',$str);
        $str = str_replace('ộ','o',$str);

        $str = str_replace('ơ','o',$str);
        $str = str_replace('ỡ','o',$str);
        $str = str_replace('ớ','o',$str);
        $str = str_replace('ở','o',$str);
        $str = str_replace('ờ','o',$str);
        $str = str_replace('ợ','o',$str);        

        $str = str_replace('Ã','A',$str);
        $str = str_replace('Á','A',$str);
        $str = str_replace('Ả','A',$str);
        $str = str_replace('À','A',$str);
        $str = str_replace('Ạ','A',$str);        

        $str = str_replace('Ă','A',$str);        
        $str = str_replace('Ẵ','A',$str);        
        $str = str_replace('Ắ','A',$str);
        $str = str_replace('Ẳ','A',$str);
        $str = str_replace('Ằ','A',$str);
        $str = str_replace('Ặ','A',$str);                

        $str = str_replace('Â','A',$str);        
        $str = str_replace('Ẫ','A',$str);
        $str = str_replace('Ấ','A',$str);
        $str = str_replace('Ẩ','A',$str);
        $str = str_replace('Ầ','A',$str);
        $str = str_replace('Ậ','A',$str);
        
        $str = str_replace('Ĩ','I',$str);
        $str = str_replace('Í','I',$str);
        $str = str_replace('Ỉ','I',$str);
        $str = str_replace('Ì','I',$str);
        $str = str_replace('Ị','I',$str);

        $str = str_replace('Y','I',$str);
        $str = str_replace('Ỹ','I',$str);
        $str = str_replace('Ý','I',$str);
        $str = str_replace('Ỷ','I',$str);
        $str = str_replace('Ỳ','I',$str);
        $str = str_replace('Ỵ','I',$str);        

        $str = str_replace('Ũ','U',$str);
        $str = str_replace('Ú','U',$str);
        $str = str_replace('Ủ','U',$str);
        $str = str_replace('Ù','U',$str);
        $str = str_replace('Ụ','U',$str);

        $str = str_replace('Ư','U',$str);        
        $str = str_replace('Ứ','U',$str);
        $str = str_replace('Ứ','U',$str);
        $str = str_replace('Ử','U',$str);
        $str = str_replace('Ừ','U',$str);
        $str = str_replace('Ự','U',$str);

        $str = str_replace('Ẽ','E',$str);
        $str = str_replace('É','E',$str);
        $str = str_replace('Ẻ','E',$str);
        $str = str_replace('È','E',$str);
        $str = str_replace('Ẹ','E',$str);

        $str = str_replace('Ê','E',$str);
        $str = str_replace('Ễ','E',$str);
        $str = str_replace('Ế','E',$str);
        $str = str_replace('Ể','E',$str);
        $str = str_replace('Ề','E',$str);
        $str = str_replace('Ệ','E',$str);

        $str = str_replace('Õ','O',$str);
        $str = str_replace('Ó','O',$str);
        $str = str_replace('Ỏ','O',$str);
        $str = str_replace('Ò','O',$str);
        $str = str_replace('Ọ','O',$str);

        $str = str_replace('Ô','O',$str);
        $str = str_replace('Ỗ','O',$str);
        $str = str_replace('Ố','O',$str);
        $str = str_replace('Ổ','O',$str);
        $str = str_replace('Ồ','O',$str);
        $str = str_replace('Ộ','O',$str);

        $str = str_replace('Ơ','O',$str);
        $str = str_replace('Ỡ','O',$str);
        $str = str_replace('Ớ','O',$str);
        $str = str_replace('Ở','O',$str);
        $str = str_replace('Ờ','O',$str);
        $str = str_replace('Ợ','O',$str);        

        return $str;
    }

    public function simplify_word($str){

        $str = mb_strtoupper($str);

        $str = preg_replace("/^GI|^D|^TH|^R|^L/", "T", $str);
        $str = preg_replace("/\sGI|\sD|\sTH|\sR|\sL/", " T", $str);
        $str = preg_replace("/^NGH|^NG|^GH/", "G", $str);
        $str = preg_replace("/\sNGH|\sNG|\sGH/", " G", $str);
        $str = preg_replace("/^TR|^CH/", "CH", $str);
        $str = preg_replace("/\sTR|\sCH/", " CH", $str);
        $str = preg_replace("/^KH|^H|^Q|^C|^Q/", "K", $str);
        $str = preg_replace("/\sKH|\sH|\sQ|\sC|\sQ/", " K", $str);
        $str = preg_replace("/^NH|^M/", "N", $str);
        $str = preg_replace("/\sNH|\sM/", " N", $str);
        $str = preg_replace("/^PH|^P|^V/", "B", $str);
        $str = preg_replace("/\sPH|\sP|\sV/", " B", $str);
        $str = preg_replace("/^X/", "S", $str);
        $str = preg_replace("/\sX/", " S", $str);                
        $str = preg_replace("/^Y/", "I", $str);        
        $str = preg_replace("/\sY/", " I", $str);

        $str = preg_replace("/NH$|M$|NG$/", "N", $str);
        $str = preg_replace("/NH\s|M\s|NG\s/", "N ", $str);
        $str = preg_replace("/P$/", "B", $str);
        $str = preg_replace("/P\s/", "B ", $str);
        $str = preg_replace("/K$|Q$/", "C", $str);
        $str = preg_replace("/K\s|Q\s/", "C ", $str);        


        // $str = preg_replace("/^gi|^d|^th|^r|^l/", "T", $str);
        // $str = preg_replace("/\sgi|\sd|\sth|\sr|\sl/", " T", $str);
        // $str = preg_replace("/^ngh|^ng|^gh/", "G", $str);
        // $str = preg_replace("/\sngh|\sng|\sgh/", " G", $str);
        // $str = preg_replace("/^tr|^ch/", "CH", $str);
        // $str = preg_replace("/\str|\sch/", " CH", $str);
        // $str = preg_replace("/^kh|^h|^q|^c|^q/", "K", $str);
        // $str = preg_replace("/\skh|\sh|\sq|\sc|\sq/", " K", $str);
        // $str = preg_replace("/^nh|^m/", "N", $str);
        // $str = preg_replace("/\snh|\sm/", " N", $str);
        // $str = preg_replace("/^ph|^p|^v/", "B", $str);
        // $str = preg_replace("/\sph|\sp|\sv/", " B", $str);
        // $str = preg_replace("/^x/", "S", $str);
        // $str = preg_replace("/\sx/", " S", $str);                
        // $str = preg_replace("/^y/", "I", $str);        
        // $str = preg_replace("/\sy/", " I", $str);

        // $str = preg_replace("/nh$|m$|ng$/", "N", $str);
        // $str = preg_replace("/nh\s|m\s|ng\s/", "N ", $str);
        // $str = preg_replace("/p$/", "B", $str);
        // $str = preg_replace("/p\s/", "B ", $str);
        // $str = preg_replace("/k$|q$/", "C", $str);
        // $str = preg_replace("/k\s|q\s/", "C ", $str);        
        
        return $str;
    }
}
<?php

namespace App\Http\Controllers;

use DB;
use App\Learn;
use App\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearnController extends Controller
{
    public function store(Request $request)
    {
        if(Auth::check()){
            $user_id = Auth::id();        
            $now = date("Y-m-d H:i:s");
            $word = Word::where('name',$request->name)->first();
            $word_id = $word->id;
            $interval = 0;
            switch ($request->easiness) {
                case 0:
                    $interval = 0.11;
                    break;
                case 1:
                    $interval = 16;
                    break;
                case 2:
                    $interval = 128;
                    break;
                case 3:
                    $interval = 1024;
                    break;                
            }
            $deviation = (2*mt_rand() - mt_getrandmax())/mt_getrandmax() * 0.3;
            $interval = $interval * (1 + $deviation);
            $interval_text ="now +".$interval." hours";

            $learn = Learn::create([
                'user_id'=> $user_id,
                'word_id'=> $word_id,
                'result'=> $request->result,
                'easiness' => $request->easiness,
                'next_time'=> date("Y-m-d H:i:s",strtotime($interval_text)),
            ]);

            return $word;
        }
    }
    public function getWords(Request $request){
        if(Auth::check() === false){ //ログイン未の場合
            $answer = Word::where('level', $request->level)->inRandomOrder()->first();
        }else{ //ログイン済の場合

            //未学習の単語をカウント //ここはuserControllerの一部をコピペしてきたから、本気出せば関数化して共用できる。
            $unlearned_word_counts = DB::select(DB::raw("
            select  level, count(*)
            from (
                select words.id, words.level, max(learns.id) as latest_id 
                from words left join learns 
                on words.id = learns.word_id 
                where learns.user_id is null or learns.user_id =".Auth::id()."
                group by words.id 
            ) as words
            where latest_id is null
            group by level
            "));

            $unlearned_word_has_this_level = false; //未学習の単語が一つでもあるかないか
            foreach($unlearned_word_counts as $unlearned_word_count){
                if($unlearned_word_count->level === (int)$request->level){
                    $unlearned_word_has_this_level=true;
                }
            }

           //学習待ちの単語をカウント
            $learned_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')//学習レコードから、単語ごとに最新のものを取り出す。 ここもDB::rawにした方が短くなる。
            ->where('words.level', $request->level )    
            ->where('learns.user_id', Auth::id())
            ->select('learns.word_id',DB::raw("MAX(learns.id) as latest_id"))               
            ->groupby('learns.word_id') // ここでlatest_idのみを配列で取り出せたら早くなるが、selectでなぜかエラーが出る。
            ->get()->toArray();
            $learned_ids=[];//学習idを単なる配列に変換
            foreach($learned_words as $learned_word){
                $learned_ids[] = $learned_word['latest_id']; 
            }
            $delayed_word_count=Learn::wherein('learns.id', $learned_ids) ->where('next_time','<',date("Y-m-d H:i:s")) ->count();

            //delay_degreeの計算
            if(!$unlearned_word_has_this_level && $delayed_word_count === 0){//単語が尽きたときはここでreturn
                return "CLEARED";
            }else if(!$unlearned_word_has_this_level){
                $delay_degree = 0;
            }else if($delayed_word_count === 0){
                $delay_degree = 1;
            }else{

                if($delayed_word_count <= 20){
                    $delay_degree= $delayed_word_count*0.025;
                }else{
                    $delay_degree= 1- 10 / $delayed_word_count;
                }

                if( count($learned_ids) < 2 ){
                    $delay_degree = 0;
                }
            }
            
            if( mt_rand() / mt_getrandmax() > $delay_degree ) { //未習の単語から一つ選択
                $next_word_id = collect(DB::select(DB::raw("
                    select words.id, max(learns.id) as latest_id 
                    from words left join learns 
                    on words.id = learns.word_id 
                    where (learns.user_id is null or learns.user_id =".Auth::id().") and words.level =". $request->level. "
                    group by words.id having max(learns.id) is null
                    ")))
                ->random()->id;

            }else{  //既習の単語から一つ選択
                $next_words=Learn::wherein('learns.id', $learned_ids)//学習目標日が最も早いものを取得
                    ->orderby('next_time','asc')
                    ->join('words','learns.word_id','=','words.id')
                    ->take(2)->get()->toArray();
                if($next_words[0]['name'] !== $request->previous){
                    $next_word_id = $next_words[0]['id'];
                }else{
                    $next_word_id = $next_words[1]['id'];
                }
            }

            $answer = Word::where('id',$next_word_id)->first();
        }

        $length = strlen($answer->simplified);
        $similar_str = substr($answer->simplified,0,$length-1);
        $semi_similar_str = substr($answer->simplified,0,$length-2);

        $similar_pronunciations =  Word::where('level', '<=', $answer->level+1)->where('simplified', 'like', "$similar_str%")->where('name', '!=', $answer->name)->inRandomOrder()->get()->all();
        $semi_similar_pronunciations =  Word::where('level', '<=', $answer->level+1)->where('simplified', 'like', "$semi_similar_str%")->where('simplified', 'not like', "$similar_str%")->where('name', '!=', $answer->name)->inRandomOrder()->get()->all();
        $dissimilar_pronunciations = Word::where('level', '<=', $answer->level+1)->where('level', '>=', $answer->level - 2)->where('simplified', 'not like', "$semi_similar_str%")->inRandomOrder()->get()->all();

        $candidates = array_slice(array_merge($similar_pronunciations, $semi_similar_pronunciations, $dissimilar_pronunciations),0,5);
        shuffle($candidates);
        $others = $candidates;

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

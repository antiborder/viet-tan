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
                    $min = 7;
                    break;
                case 1:
                    $min = 16 *60; //= 24 * 2/3
                    break;
                case 2:
                    $min = 112*60; //= 24*7* 2/3
                    break;
                case 3:
                    $min = 784*60; //= 24*7*7* 2/3
                    break;                
            }
            
            $deviation = (2 * mt_rand() / mt_getrandmax() - 1) * 0.3;
            $min = round( $min * (1 + $deviation),0);
            $interval_text ="now +".$min." minutes";

            $learn = Learn::firstOrNew([ 'user_id'=> $user_id, 'word_id'=> $word_id,]);
            $learn -> fill([
                'result'=> $request->result,
                'easiness' => $request->easiness,
                'next_time'=> date("Y-m-d H:i:s",strtotime($interval_text)),
            ]);
            $learn->save();
            return $learn;

            return $word;
        }
    }
    public function getWords(Request $request){

        if(Auth::check() === false){ //ログイン未の場合
            $answer = Word::where('level', $request->level)->inRandomOrder()->first();
        }else{ //ログイン済の場合

            //未学習の単語をカウント
            $unlearned_word_ids = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
            ->whereNull('learns.user_id')
            ->where('words.level',$request->level)
            ->select('words.id')
            ->get();
            $unlearned_word_count = $unlearned_word_ids -> count();

           //学習待ちの単語をカウント
           $delayed_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
           ->where('learns.user_id', Auth::id())
           ->where('words.level',$request->level)
           ->where('learns.next_time', '<', date("Y-m-d H:i:s"))
           ->get();
           $delayed_word_count = $delayed_words->count();

            //delay_degreeの計算
            if($unlearned_word_count===0 && $delayed_word_count === 0){//単語が尽きたときはここでreturn
                return "CLEARED";
            }else if($unlearned_word_count===0){
                $delay_degree = 1;
            }else if($delayed_word_count === 0){
                $delay_degree = 0;
            }else{

                if($delayed_word_count <= 10){
                    $delay_degree= $delayed_word_count*0.05;
                }else{
                    $delay_degree= 1.0 - 5 / $delayed_word_count;
                }

                if( $unlearned_word_count < 2 ){
                    $delay_degree = 0;
                }
            }
            
            if( mt_rand() / mt_getrandmax() > $delay_degree ) { //未習の単語から一つ選択

                $next_word_id = $unlearned_word_ids ->random()->id;
                
            }else{  //既習の単語から一つ選択

                $next_words= $delayed_words
                ->sortBy('next_time')
                ->sortBy('easiness')
                ->values()
                ->take(2);

                if($next_words[0]['name'] !== $request->previous){
                    $next_word_id = $next_words[0]['word_id'];
                }else{
                    $next_word_id = $next_words[1]['word_id'];
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

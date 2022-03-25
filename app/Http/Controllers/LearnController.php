<?php

namespace App\Http\Controllers;

use DB;
use App\Learn;
use App\Word;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearnController extends Controller
{

    public function learn(...$level)
    {
        $user = User::where('id',Auth::id())->first();
        $user_name = $user !== null ? $user->name : null;
        if(count($level) === 0){
            $level[0]=1;
        }

        return view('words.learn',['user_name' => $user_name, 'level'=> $level[0]]);
    }

    public function store(Request $request)
    {
        if(Auth::check()){
            $user_id = Auth::id();        
            $now = date("Y-m-d H:i:s");
            $word = Word::where('name',$request->name)->first();
            $word_id = $word->id;
            $previous_learn = Learn::where('user_id', $user_id)->where('word_id', $word_id)->first();

            // calculate point
            if($previous_learn === null){
                $interval_point = 0;
            }else{
                $interval_point = $this->getIntervalPoint($previous_learn->updated_at, $previous_learn->next_time);
            }
            $easiness_point = $this->getEasinessPoint($request->easiness);
            $point = ($easiness_point+ $interval_point)/2;

            //calculate progress
            $initial_progress = 0.1;
            if($previous_learn === null){
                $previous_progress = $initial_progress;
            }else{
                $previous_progress = $previous_learn->progress === null ? $initial_progress : $previous_learn->progress;
            }
            $progress =  ($point + 2 * $previous_progress) / 2;

            //calculate interval
            if($request->easiness === 0){
                $min = 7;
            }else{
                $min = round( $this->getInterval($point), 0);
            }
            $min = round($min,0);
            $interval_text ="now +".$min." minutes";

            $learn = Learn::firstOrNew([ 'user_id'=> $user_id, 'word_id'=> $word_id,]);
            $learn -> fill([
                'result'=> $request->result,
                'easiness' => $request->easiness,
                'next_time'=> date("Y-m-d H:i:s",strtotime($interval_text)),
                'progress'=> $progress,
            ]);
            $learn->save();

        }
    }

    public function getIntervalPoint($updated_at, $next_time){
        $min = ( strtotime($next_time) - strtotime($updated_at) )/60;
        if ($min < 360){
            $interval_point = 0;
        }else{
            $interval_point = log( $min/(6*60) , 2)/8;
        }
        return $interval_point;
    }
    
    public function getEasinessPoint($easiness){
        switch ($easiness) {
            case 0:
                $easiness_point = 0.11;
                break;
            case 1:
                $easiness_point = 0.33;
                break;
            case 2:
                $easiness_point = 0.56;
                break;
            case 3:
                $easiness_point = 0.78;
                break;                
        }
        return $easiness_point;
    }

    public function getInterval($point){
        $min = 6 * 60 * 2**(8*$point);
        return $min;
    }
    
    public function getWords(Request $request){

        if(Auth::check() === false){ //ログイン未の場合
            $answer = Word::where('level', $request->level)->inRandomOrder()->first();
        }else{ //ログイン済の場合

            $total_count = Word::where('words.level',$request->level)->get()->count();

            //既習語取得
            $learned_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
            ->where('learns.user_id',Auth::id())
            ->where('words.level',$request->level)
            ->select('words.id')
            ->get()->toArray();
            $learned_word_ids = array_map(
                function ($element) { 
                    return $element['id']; 
                },
                $learned_words
            );
            $learned_word_count = count($learned_word_ids);

            //未習語を取得
            $unlearned_words = Word::where('words.level',$request->level)
            ->whereNotIn('id',$learned_word_ids)->
            select('id')->get();
            $unlearned_word_count = $unlearned_words->count();
            
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

                $next_word_id = $unlearned_words ->random()->id;
                
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

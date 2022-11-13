<?php
namespace App\Http\Controllers;

use DB;
use App\Learn;
use App\Word;
use App\User;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearnController extends Controller
{

    public function learn(...$level)
    {
        $subscription = User::getSubscription();
        $user_name= User::getUserName();

        if(count($level) === 0){
            $level[0] = 1;
        }

        return view('words.learn',['user_name'=>$user_name, 'subscription'=>$subscription, 'level'=>$level[0]]);
    }

    public function measure()
    {
        $subscription = User::getSubscription();
        return view('words.measure');
    }

    public function store(Request $request)
    {
        if(Auth::check()){
            $user_id = Auth::id();
            $now = date("Y-m-d H:i:s");
            $word = Word::where('name',$request->name)->first();
            $word_id = $word->id;
            $previous_learn = Learn::where('user_id', $user_id)->where('word_id', $word_id)->first();

            // pointを計算。進捗point = (easiness + interval)/2 + speed
            $initial_interval_point = 0.38;//出題一回目の初期補正。
            if($previous_learn === null){
                $previous_progress = 0;
                $previous_progress_MF = 0;
                $interval_point = $initial_interval_point;
            }else{
                $previous_progress = $previous_learn->progress === null ? 0 : $previous_learn->progress;
                $previous_progress_MF = $previous_learn->progress_MF === null ? 0 : $previous_learn->progress_MF;
                $interval_point = $this->getIntervalPoint($previous_learn->updated_at, $previous_learn->next_time);
            }
            $easiness_point = $this->getEasinessPoint($request->easiness);
            $speed_point = - 0.15 * 2/config('const.TIME_LIMIT') * ($request->sec - config('const.TIME_LIMIT')/2 );
            $point = ($easiness_point + $interval_point)/2 + $speed_point;

            //Modeは言語方向を表す(FM:越->日, MF:日->越)。M:Mother lang,F:Foreign lang
            if($request->mode === "FM"){
                $progress = $point;
                if($previous_progress_MF <= 0.5*$point){ //相方が少なすぎる場合には底上げ
                    $progress_MF = 0.5*$point;
                }else{
                    $progress_MF = $previous_progress_MF; //逆の場合は前回を引き継ぎ
                }
            }else if($request->mode === "MF"){
                $progress_MF = $point;
                if($previous_progress <= 0.5*$point){ //相方が少なすぎる場合には底上げ
                    $progress = 0.5*$point; // <-20220709修正
                }else{
                    $progress = $previous_progress; //逆の場合は前回を引き継ぎ
                }
            }

            //select next mode.次回出題時のmodeはrandomに決める。
            $scale_factor = 5/3; //大きさ調整の係数。progressの差が0.3開いたら苦手な方の出題率100%となるようにした。
            $criteria = ($progress - $progress_MF) * $scale_factor;//これが0なら半々の確率。0意外ならただし苦手な方が出やすくなってる。
            if($criteria > mt_rand() / mt_getrandmax() - 0.5){
                $next_mode = "MF";
            }else{
                $next_mode = "FM";
            }

            //calculate next interval
            if($request->easiness === 0){
                $min = 5;
            }else{
                $random_factor = (mt_rand() / mt_getrandmax() - 0.5)/5;//出題時刻が固まらないようにランダム補正。
                if($next_mode === "MF"){
                    $min = round( $this->getInterval($progress_MF + $random_factor), 0);
                }else if($next_mode === "FM"){
                    $min = round( $this->getInterval($progress + $random_factor), 0);
                }
            }
            $interval_text ="now +".$min." minutes";

            //Learn tableに格納。
            $learn = Learn::firstOrNew([ 'user_id'=> $user_id, 'word_id'=> $word_id,]);
            $learn -> fill([
                'result'=> $request->result,
                'easiness' => $request->easiness,
                'next_time'=> date("Y-m-d H:i:s",strtotime($interval_text)),
                'progress'=> $progress,
                'progress_MF'=> $progress_MF,
                'next_mode' => $next_mode,
            ]);
            $learn->save();
        }
    }

    private function getIntervalPoint($updated_at, $next_time){
        $min = ( strtotime($next_time) - strtotime($updated_at) )/60;
        if ($min < 360){
            $interval_point = 0;
        }else{
            $interval_point = log( $min/(6*60) , 2)/8; //getIntervalの逆演算
        }
        return $interval_point;
    }

    private function getEasinessPoint($easiness){
        switch ($easiness) {
            case 0:
                $easiness_point = 0.15;
                break;
            case 1:
                $easiness_point = 0.38;
                break;
            case 2:
                $easiness_point = 0.62;
                break;
            case 3:
                $easiness_point = 0.85;
                break;
        }
        return $easiness_point;
    }

    private function getInterval($point){
        $min = 6 * 60 * 2**(8*$point); //最大(point=1)で64日、中間(point=0.5)で4日。
        return $min;
    }

    public function getWords(Request $request){

        $previous_word = Word::where('name',$request->previous)->first();
        $previous_word_ids = is_null($previous_word) ? [] : [$previous_word->id];

        if($request->component === 'measure'){ //単語力測定の場合
            $answer = Word::where('level', $request->level)->inRandomOrder()->first();
            $FM_ratio = 2/3; //越⇒日で出題する確率。50%より大きくしてある。
            if(mt_rand() / mt_getrandmax() < $FM_ratio){
                $mode = "FM";
            }else{
                $mode = "MF";
            }

        }else if($request->component === 'learn'){ //単語学習の場合

            if(Auth::check() === false){ //ログイン未の場合
                $answer = Word::where('level', $request->level)->inRandomOrder()->first();
                $mode = "FM"; //いつも越⇒日で出題。

            }else{ //ログイン済の場合

                //除外タグと除外単語idのリスト
                $user = Auth::user();
                $excluded_tags = [];
                if($user->excludes_south){
                    array_push($excluded_tags,"南部方言");
                }
                if($user->excludes_north) {
                    array_push($excluded_tags,"北部方言");
                }
                $excluded_word_ids = Word::select('id')->whereHas('tags', function($q)use($excluded_tags) {
                    $q->whereIn('name', $excluded_tags);
                })->get();

                if($request->level==="REVIEW_ALL"){

                    //出題待ちの単語をカウント
                    $delayed_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
                        ->where('learns.user_id', Auth::id())
                        ->where('learns.next_time', '<', date("Y-m-d H:i:s"))
                        ->whereNotIn('words.id',$excluded_word_ids)
                        ->whereNotIn('words.id',$previous_word_ids)
                        ->get();
                    $delayed_word_count = $delayed_words->count();

                    // return $delayed_word_count;

                    if($delayed_word_count === 0){//単語が尽きたときはここでreturn
                        return "CLEARED";
                    }

                    $next_word= $delayed_words->sortBy('next_time')->sortBy('easiness')->first();
                    $next_word_id = $next_word->word_id;
                    $mode = $next_word['next_mode']===null ? "FM" : $next_word['next_mode'];
                    // return [$next_word_id,$mode]; //デバッグ用


                    // $next_words= $delayed_words->sortBy('next_time')->sortBy('easiness')->values()->take(2);//学習順で一番前にあるのだけでなく、次のも取ってる。同じ単語を2連続で取ってしまわないように。

                    // if($next_words[0]['name'] !== $request->previous){ //一番前のが直前の出題語じゃないなら、そのまま出題。
                    //     $next_word_id = $next_words[0]['word_id'];
                    //     $mode = $next_words[0]['next_mode'] === null ? "FM" : $next_words[0]['next_mode'];
                    // }else{ //一番前のが直近の出題語だった場合
                    //     if($delayed_word_count === 1){//単語が尽きたときはここでreturn
                    //         return "CLEARED";
                    //     }
                    //     $next_word_id = $next_words[1]['word_id']; //次のを出題
                    //     $mode = $next_words[1]['next_mode']===null ? "FM" : $next_words[1]['next_mode'];
                    // }

                }else{ //levelを選択した場合。既習後と未習後を良い感じに混ぜて出題する仕様。

                    //既習語取得
                    $learned_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
                        ->where('learns.user_id',Auth::id())
                        ->where('words.level',$request->level)
                        ->whereNotIn('words.id',$excluded_word_ids)
                        ->select('words.id')
                        ->get()
                        // ->toArray() //動作確認出来たら消す。
                        ;

                        //動作確認出来たら消す。↓
                    // $learned_word_ids = array_map(
                    //     function ($element) {
                    //         return $element['id'];
                    //     },
                    //     $learned_words
                    // );
                    // $learned_word_count = $learned_words->count();

                    //未習語を取得
                    $unlearned_words = Word::where('words.level',$request->level)
                    ->whereNotIn('words.id',$learned_words)
                    ->whereNotIn('words.id',$excluded_word_ids)
                    ->whereNotIn('words.id',$previous_word_ids)
                    // ->select('id') //動作確認できたら消す
                    ->get()
                    ;
                    $unlearned_word_count = $unlearned_words->count();


                    //出題待ちの単語をカウント
                    $delayed_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
                    ->where('learns.user_id', Auth::id())
                    ->where('words.level',$request->level)
                    ->where('learns.next_time', '<', date("Y-m-d H:i:s"))
                    ->whereNotIn('words.id',$excluded_word_ids)
                    ->whereNotIn('words.id',$previous_word_ids)
                    ->get();
                    $delayed_word_count = $delayed_words->count();

                    //学習の遅れ度を示すdelay_degreeの計算。
                    if( $unlearned_word_count===0 && $delayed_word_count===0 ){//単語が尽きたときはここでreturn
                        return "CLEARED";
                    }else if($delayed_word_count===0){ //遅れなしの場合
                        $delay_degree = 0;
                    }else if($unlearned_word_count===0){ //未習なしの場合
                        $delay_degree = 1;
                    }else{
                        if($delayed_word_count <= 10){ //0語から10個までは比例関係。
                            $delay_degree= $delayed_word_count*0.05;
                        }else{ //10個を超えたら負の反比例。
                            $delay_degree= 1.0 - 5 / $delayed_word_count;
                        }
                    }


                    // if( $unlearned_word_count===0 && $delayed_word_count===0 ){//単語が尽きたときはここでreturn
                    //     return "CLEARED";
                    // }else if($delayed_word_count===0){ //遅れなしの場合
                    //     $delay_degree = 0;
                    // }else if($unlearned_word_count===0 || $unlearned_word_count===1){ //0だけでなく、未習語数1と計算したけどすでに0になってる場合も考慮。
                    //     $delay_degree = 1; //delay_degreeを1にして、未習後をtakeしないようにしてる
                    // }else{
                    //     if($delayed_word_count <= 10){ //0語から10個までは比例関係。
                    //         $delay_degree= $delayed_word_count*0.05;
                    //     }else{ //10個を超えたら負の反比例。
                    //         $delay_degree= 1.0 - 5 / $delayed_word_count;
                    //     }
                    // }

                    if( mt_rand() / mt_getrandmax() > $delay_degree ) { //未習の単語から一つ選択
                        $next_word_id = $unlearned_words ->random()->id;
                        $mode = "FM";
                    }else{  //既習の単語から一つ選択

                        $next_word = $delayed_words->sortBy('next_time')->sortBy('easiness')->first();
                        $next_word_id = $next_word->word_id;
                        $mode = $next_word['next_mode']===null ? "FM" : $next_word['next_mode'];

                        // $next_words= $delayed_words->sortBy('next_time')->sortBy('easiness')->values()->take(2);//学習順で一番前にあるのだけでなく、次のも取ってる。同じ単語を2連続で取ってしまわないように。
                        // if($next_words[0]['name'] !== $request->previous){
                        //     $next_word_id = $next_words[0]['word_id'];
                        //     $mode = $next_words[0]['next_mode'] === null ? "FM" : $next_words[0]['next_mode'];
                        // }else{
                        //     if($unlearned_word_count + $delayed_word_count === 1){//単語が尽きたときはここでreturn
                        //         return "CLEARED";
                        //     }
                        //     $next_word_id = $next_words[1]['word_id'];
                        //     $mode = $next_words[1]['next_mode']===null ? "FM" : $next_words[1]['next_mode'] ;
                        // }
                    }
                }

                $answer = Word::where('id',$next_word_id)->first();
            }
        }
        $synonyms = [];
        foreach($answer->synonyms() as $synonym ){
                $synonyms[] = $synonym->name;
        }

        $length = strlen($answer->simplified);
        $similar_str = substr($answer->simplified,0,$length-1);
        $semi_similar_str = substr($answer->simplified,0,$length-2);

        $similar_pronunciations =  Word::where('level', '<=', $answer->level+1)->where('simplified', 'like', "$similar_str%")->where('name', '!=', $answer->name)->whereNotIn('name', $synonyms)->inRandomOrder()->get()->all();
        $semi_similar_pronunciations =  Word::where('level', '<=', $answer->level+1)->where('simplified', 'like', "$semi_similar_str%")->where('simplified', 'not like', "$similar_str%")->where('name', '!=', $answer->name)->whereNotIn('name', $synonyms)->inRandomOrder()->get()->all();
        $dissimilar_pronunciations = Word::where('level', '<=', $answer->level+1)->where('level', '>=', $answer->level - 2)->where('simplified', 'not like', "$semi_similar_str%")->whereNotIn('name', $synonyms)->inRandomOrder()->get()->all();

        $candidates = array_slice(array_merge($similar_pronunciations, $semi_similar_pronunciations, $dissimilar_pronunciations),0,5);
        shuffle($candidates);
        $others = $candidates;

        return [
            'mode' => $mode,
            'answer' => $this->formatWord($answer),
            'others' =>[
                $this->formatWord($others[0]),
                $this->formatWord($others[1]),
                $this->formatWord($others[2]),
            ],
        ];

    }

    private function formatWord(Word $word){
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

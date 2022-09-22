<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Word;
use App\Learn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(String $name){
        $user = User::where('name', $name)->first();

        if(Auth::id() === $user->id || Auth::id() === 1 ){
            $status = Word::select('level',DB::raw('count(*) as total'))->groupBy('level')->orderBy('level')->get()->toArray();
            $subscription = User::getSubscription();

            //既習語数を取得
            $learned_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
            ->where('learns.user_id',$user->id)
            ->select('words.level',DB::raw('count(*) as count'))
            ->groupBy('words.level')
            ->get();

            //復習可能語数を計算
            $ready_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
            ->where('learns.user_id',$user->id)
            ->where('learns.next_time', '<', date("Y-m-d H:i:s"))
            ->select('words.level',DB::raw('count(*) as count'))
            ->groupBy('words.level')
            ->get();

            //レベル毎progressを計算
            $level_averages = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
            ->where('learns.user_id',$user->id)
            ->select('words.level',DB::raw('avg((progress+"progress_MF")/2) as progress'))
            ->groupBy('words.level')
            ->get();

            //$easiness毎の既習語数を取得
            $learned_word_details = [];
            for($e=0;$e<4;$e++){ //$eはeasiness
                $learned_word_details[] = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
                ->where('learns.user_id',$user->id)
                ->where('learns.easiness', $e)
                ->select('words.level',DB::raw('count(*) as count'))
                ->groupBy('words.level')
                ->get();
            }

            //学習予定      //現在時刻はnow() - cast ('9 hours' as interval)。　now()で求まるGMTを日本時刻に変換している。
            $schedule_counts = DB::select("
                select day, count(*) as count
                from (
                    select extract( day from (next_time - now() - cast ('9 hours' as interval) ))+1 as day
                    from learns
                    where user_id = " . $user->id . "
                    and next_time > now() + cast ('9 hours' as interval)
                )
                as diff
                group by day
            ");

            $ready_total = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
            ->where('learns.user_id',$user->id)
            ->where('learns.next_time', '<', date("Y-m-d H:i:s"))
            ->get()->count();

            //学習実績
            $history_counts = DB::select("
                select day, count(*) as count
                from (
                    select extract( day from (  now() + cast ('9 hours' as interval) - updated_at  ))+1 as day
                    from learns
                    where user_id = " . $user->id . "
                )
                as diff
                group by day
            ");

            //viewに渡す変数の準備
            $levels = [];
            $total = array();
            foreach($status as $s){
                $levels[] = $s['level'];
                $total[$s['level']] = $s['total'];
            }

            $learned=array();
            $unlearned=array();
            $ready =array();
            $progress = array();

            //viewに渡す値の計算
            foreach($levels as $l){
                $learned[$l] = 0;
                foreach($learned_words as $learned_word){
                    if($l===$learned_word->level){
                        $learned[$l] = $learned_word->count;
                        break;
                    }
                }

                $unlearned[$l] = $total[$l] - $learned[$l];

                $ready[$l] = 0;
                foreach($ready_words as $ready_word){
                    if($l===$ready_word->level){
                        $ready[$l] = $ready_word->count;
                        break;
                    }
                }

                $progress[$l] = 0;
                foreach($level_averages as $level_average){
                    if($l===$level_average->level){
                        $progress[$l] = round(( $level_average->progress * $learned[$l] ) / ( $learned[$l] + $unlearned[$l] )*100);
                        break;
                    }
                }
                //easiness毎の既習語数
                for($e=0;$e<4;$e++){ //$eはeasiness
                    $learned_details[$e][$l] = 0;
                    foreach($learned_word_details[$e] as $element){
                        if($l===$element->level){
                            $learned_details[$e][$l] = $element->count;
                            break;
                        }
                    }
                }
            }

            //viewに渡す学習予定
            $schedule = array();
            for($i=1;$i<=60;$i++){
                $schedule[$i] = 0;
                foreach($schedule_counts as $schedule_count){
                    if($i === (int)$schedule_count->day){
                        $schedule[$i] = $schedule_count->count;
                    }
                }
            }
            //viewに渡す学習実績
            $history = array();
            for($i=1;$i<=60;$i++){
                $history[$i] = 0;
                foreach($history_counts as $history_count){
                    if($i === (int)$history_count->day){
                        $history[$i] = $history_count->count;
                    }
                }
            }

           return view('users.show', [
                'user' => $user,
                'subscription' => $subscription,
                'status' => $status,
                'ready' => $ready,
                'learned' => $learned,
                'unlearned' => $unlearned,
                'progress' => $progress,

                'learned_details' =>$learned_details,
                // 'learned_1' =>$learned_details[1],
                // 'learned_2' =>$learned_details[2],
                // 'learned_3' =>$learned_details[3],

                'schedule' =>$schedule,
                'ready_total' =>$ready_total,
                'history' =>$history,
            ]);
        }else{
            return view('index');
        }
    }

    public function list(){
        if(Auth::id() === 1 ){
            $users = User::all();

            $users = User::leftjoin('learns', 'users.id', '=', 'learns.user_id')
            ->select('users.id','users.name','users.email','users.created_at','users.updated_at',DB::raw('max(learns.updated_at) as latest_learn'))
            ->groupBy('users.id')
            ->get();
                // return $users;
            return view('users.list', ['users'=>$users] );
        }else{
            return view('index');
        }
    }

}

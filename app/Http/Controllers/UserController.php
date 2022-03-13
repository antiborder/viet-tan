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
            ->select('words.level',DB::raw('avg(progress) as progress'))
            ->groupBy('words.level')
            ->get();        

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
            }

            return view('users.show', [
                'user' => $user,
                'status' => $status,
                'ready' => $ready,
                'learned' => $learned,
                'unlearned' => $unlearned,
                'progress' => $progress,
            ]);
        }else{
            return view('index');
        }
    }
}

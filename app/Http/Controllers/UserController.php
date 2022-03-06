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
        $status = Word::select('level',DB::raw('count(*) as total'))->groupBy('level')->orderBy('level')->get()->toArray();
      
        $unlearned_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
        ->whereNull('learns.user_id')
        ->select('words.level',DB::raw('count(*) as count'))
        ->groupBy('words.level')
        ->get();

        $learned_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
        ->where('learns.user_id',Auth::id())
        ->select('words.level',DB::raw('count(*) as count'))
        ->groupBy('words.level')
        ->get();

        $ready_words = Word::leftjoin('learns', 'words.id', '=', 'learns.word_id')
        ->where('learns.user_id',Auth::id())
        ->where('learns.next_time', '<', date("Y-m-d H:i:s"))
        ->select('words.level',DB::raw('count(*) as count'))
        ->groupBy('words.level')
        ->get();

        $levels = [];
        foreach($status as $s){
          $levels[] = $s['level'];
        }

        $learned=array();
        $unlearned=array();
        $ready =array();

        foreach($levels as $l){
            foreach($learned_words as $learned_word){
                if($l===$learned_word->level){
                    $learned[$l] = $learned_word->count;
                    break;
                }
                $learned[$l] = 0;
            }

            foreach($unlearned_words as $unlearned_word){
                if($l===$unlearned_word->level){
                    $unlearned[$l] = $unlearned_word->count;
                    break;
                }
                $unlearned[$l] = 0;
            }
            
            foreach($ready_words as $ready_word){
                if($l===$ready_word->level){
                    $ready[$l] = $ready_word->count;
                    break;
                }
                $ready[$l] = 0;
            }
        }

        return view('users.show', [
            'user' => $user,
            'status' => $status,
            'ready' => $ready,
            'learned' => $learned,
            'unlearned' => $unlearned

        ]);



    }
}

<?php

namespace App\Http\Controllers;

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
            switch ($request->easiness) {
                case 0:
                    $interval_text ="now +10 min +0 hours";
                    break;
                case 1:
                    $interval_text ="now +24 hours";
                    break;
                case 2:
                    $interval_text ="now +72 hours";
                    break;
                case 3:
                    $interval_text ="now +168 hours";
                    break;                
            }

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
}

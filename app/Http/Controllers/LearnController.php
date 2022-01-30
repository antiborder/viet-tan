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

        // $user_id = $request->user;
        $user_id = Auth::id();        
        $now = date("Y-m-d H:i:s");
        $word = Word::where('name',$request->name)->first();
        // $word_id = $word->id;
        $word_id = $word->id;
        $learn = Learn::create([
            'user_id'=> $user_id,
            'word_id'=> $word_id,
            'result'=> $request->result,
            'easiness' => $request->easiness,
            'next_time'=> $now,
        ]);

        return $word;

        // return $request;
        // return [
        //     $learn->easiness        ];
    }
}

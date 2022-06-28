<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactSendmail;

class ContactController extends Controller
{
    public function index(){
        return view('contact.index');

    }

    public function confirm(Request $request){
        //バリデーションを実行（結果に問題があれば処理を中断してエラーを返す）
        $request->validate([
            'email' => 'required|email',
            'title' => 'required',
            'body'  => 'required',
        ]);
        
        //フォームから受け取ったすべてのinputの値を取得
        $inputs = $request->all();

        //入力内容確認ページのviewに変数を渡して表示
        return view('contact.confirm', [
            'inputs' => $inputs,
        ]);        

    }

    public function send(Request $request){

        //バリデーションを実行（結果に問題があれば処理を中断してエラーを返す）
        $request->validate([
            'email' => 'required|email',
            'title' => 'required',
            'body'  => 'required'
        ]);

        //フォームから受け取ったactionの値を取得
        $action = $request->input('action');
        
        //フォームから受け取ったactionを除いたinputの値を取得
        $inputs = $request->except('action');

        //actionの値で分岐
        if($action !== 'submit'){
            return redirect()
                ->route('contact.index')
                ->withInput($inputs);

        } else {

            //スパムをフィルタ
            $is_spam === false;
            $ng_words = ['de','ロボット','.se/','.es/'];
            foreach($ng_words as $ng_word){
                if(strpos( $request['body'], $ng_word ) !== false){
                    $is_spam === true;
                }
            }

            //入力されたメールアドレスにメールを送信
            if ( $is_spam === false ) {
                \Mail::to($inputs['email'])->send(new ContactSendmail($inputs));
                \Mail::to(config('mail.from.address'))->send(new ContactSendmail($inputs));
            } else {
                //NGワードが入っています。
                return redirect()->route('words.show', ['word' => 4028]);
            }

            //再送信を防ぐためにトークンを再発行
            $request->session()->regenerateToken();

            //送信完了ページのviewを表示
            return view('contact.thanks', [
                'inputs' => $inputs,
            ]);        
        }      
    }
}

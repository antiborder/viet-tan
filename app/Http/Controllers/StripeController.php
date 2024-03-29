<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;
use Stripe\Charge;
use App\User;

class StripeController extends Controller
{


    public function subscription(Request $request){
        $user=Auth::user();
          return view('post.subscription',  [
            'user' => $user,
            'intent' => $user->createSetupIntent()
        ]);
    }

    public function afterpay(Request $request){
        // ログインユーザーを$userとする
        $user=Auth::user();
 
        // またStripe顧客でなければ、新規顧客にする
        $stripeCustomer = $user->createOrGetStripeCustomer();
 
        // フォーム送信の情報から$paymentMethodを作成する
        $paymentMethod=$request->input('stripePaymentMethod');
 
        // プランはconfigに設定したbasic_plan_idとする
        $plan=config('services.stripe.basic_plan_id');
        
        // 上記のプランと支払方法で、サブスクを新規作成する
        $user->newSubscription( 'default', $plan)
        ->create($paymentMethod);
 
        // 処理後に'ルート設定'にページ移行
        // return redirect()->route('ルート設定');
        return redirect()->route('users.show', ['name'=>Auth::user()->name]);
    }

    public function cancelsubscription(User $user, Request $request){
        $user->subscription('default')->cancelNow();
        return back();
     }

    public function portalsubscription(User $user, Request $request){
        return $request->user()->redirectToBillingPortal("https://vietnamese-learn.net");
    }
    
    
}
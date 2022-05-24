<?php

namespace App\Http\Controllers;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;
use App\Models\User;
use Carbon\Carbon;


class WebhookController extends CashierController
{
    public function handleCustomerSubscriptionDeleted(array $payload){
        // Stripeから送信されたデータからstripe_idを取得し、$id変数に代入
        $id=$payload['data']['object']['id'];
 
        // Subscriptionテーブルのstripe_idが$idと同じものを取ってくる
        $subsc = Subscription::where('stripe_id', $id)->first();
        
        // このデータのstripe_statusをcanceledにする
        $subsc->stripe_status='canceled';
        
        // このデータのends_atに、Carbonを使って今の時間を入れる
        $subsc->ends_at=Carbon::now()->timestamp;
 
        $subsc->save();
        return new Response('Webhook Handled', 200);
    }

    public function handleCustomerSubscriptionUpdated(array $payload){
        return new Response('Webhook Handled Subscription Updated', 200);
    }

    
}

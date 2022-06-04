<?php

namespace App\Http\Middleware;

use Closure;

class StripeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && ! $request->user()->subscribed('default')) {
            // このユーザーは支払っていない顧客
            return redirect()->route('stripe.subscription');
        }         
        return $next($request);
    }
}

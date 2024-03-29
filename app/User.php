<?php

namespace App;

use App\Mail\BareMail;
use App\Notifications\PasswordResetNotification;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'excludes_north', 'excludes_south'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token, new BareMail()));
    }

    public static function getSubscription() :String
    {
        $user = Auth::user();
        if( $user !== null ){
            if($user->subscribed('default')){
                $subscription = "NORMAL";
            }else{
                $subscription = "TRIAL";
            }
        }else{
            $subscription = "GUEST";
        }
        return $subscription;
    }

    public static function getUserName() :?String
    {
        $user = Auth::user();
        if( $user !== null ){
            return $user->name;
        }
        else{
            return null;
        }
    }
}
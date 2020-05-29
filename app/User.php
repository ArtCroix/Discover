<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'agreement', 'role', 'firstname', 'lastname', 'middlename', 'email', 'password', 'email_verified_at'
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

    public function submits()
    {
        return $this->belongsToMany('App\Models\Application\Submit');
    }

    public function answers()
    {
        return $this->hasManyThrough('App\Models\Application\Answer', 'App\Models\Application\Submit');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Models\Team', 'user_team');
    }
    /*     public function teams()
    {
        return $this->belongsToMany('App\Models\Team', 'event_team');
    } */

    public function events()
    {
        return $this->hasManyThrough('App\Models\Event', 'App\Models\Team');
    }
    /*  public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'event_team')->withTimestamps();
    } */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}

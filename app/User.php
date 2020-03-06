<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
        return $this->hasMany('App\Models\Application\Submit');
    }

    public function answers()
    {
        return $this->hasManyThrough('App\Models\Application\Answer', 'App\Models\Application\Submit');
    }

    public function teams()
    {
        return $this->hasMany('App\Models\Team');
    }

/*     public function questions()
{
return $this->hasManyThrough('App\Application\Question', 'App\Application\Submit');
} */
}

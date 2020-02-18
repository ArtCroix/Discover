<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function applications()
    {
        return $this->hasMany('App\Application\Application');
    }

    public function questions()
    {
        return $this->hasManyThrough('App\Application\Question', 'App\Application\Application', 'event_id', 'application_id');
    }

    // команды, в которых участвовал авторизованный пользователь
    public function teams()
    {
        return $this->belongsToMany('App\Team\Team')->wherePivot('user_id', Auth::user()->id);
    }
}

<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function applications()
    {
        return $this->hasMany('App\Models\Application\Application');
    }

    public function questions()
    {
        return $this->hasManyThrough('App\Models\Application\Question', 'App\Models\Application\Application', 'event_id', 'application_id');
    }

    // команды, в которых участвовал авторизованный пользователь
    public function teams()
    {
        return $this->belongsToMany('App\Models\Team')->wherePivot('user_id', Auth::user()->id);
    }
}

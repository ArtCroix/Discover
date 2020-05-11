<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
    public function teams_auth_user()
    {
        return $this->belongsToMany('App\Models\Team', 'event_team')->wherePivot('user_id', Auth::user()->id);
    }

    public function teams()
    {
        return $this->hasMany('App\Models\Team');
    }

    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\Models\Team');
    }

    public function user_team()
    {
        return $this->hasMany('App\Models\Team')->whereHas('users', function (Builder $query) {
            $query->where('user_id', \Auth::user()->id);
        });
    }
    /*     public function teams()
    {
        return $this->belongsToMany('App\Models\Team', 'event_team')->withTimestamps();
    } */

    public function submits()
    {
        return $this->hasManyThrough('App\Models\Application\Submit', 'App\Models\Application\Application')->withTimestamps();
    }
}

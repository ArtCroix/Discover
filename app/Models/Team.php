<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    public function application()
    {
        return $this->belongsTo('App\Models\Application\Application');
    }

    public function submit()
    {
        return $this->belongsTo('App\Models\Application\Submit');
    }

    public function questions()
    {
        return $this->hasManyThrough('App\Models\Question', 'App\Models\Application');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_team')->withTimestamps();
    }
    /*    public function users()
    {
        return $this->belongsToMany('App\User', 'event_team')->withTimestamps();
    } */
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

    public function questions()
    {
        return $this->hasManyThrough('App\Models\Question', 'App\Models\Application');
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'event_team')->withTimestamps();
    }
    public function users()
    {
        return $this->belongsToMany('App\User', 'event_team')->withTimestamps();
    }
}

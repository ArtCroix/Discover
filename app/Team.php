<?php

namespace App\Team;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    public function applications()
    {
        return $this->hasMany('App\Team\Application');
    }

    public function questions()
    {
        return $this->hasManyThrough('App\Team\Question', 'App\Team\Application');
    }

    public function events()
    {
        return $this->belongsToMany('App\Event')->withTimestamps();
    }
}

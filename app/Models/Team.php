<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    public function applications()
    {
        return $this->hasMany('App\Models\Application');
    }

    public function questions()
    {
        return $this->hasManyThrough('App\Models\Question', 'App\Models\Application');
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event')->withTimestamps();
    }
}

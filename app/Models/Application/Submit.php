<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;

class Submit extends Model
{
    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany('App\Models\Application\Answer');
    }

    public function application()
    {
        return $this->belongsTo('App\Models\Application\Application');
    }

    public function questions()
    {
        return $this->hasManyThrough('App\Models\Application\Question', 'App\Models\Application\Answer', 'submit_id', 'id', 'id', 'question_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'submit_user')->withTimestamps()->withPivot('user_id');
    }

    public function event()
    {
        return $this->hasOneThrough('App\Models\Event', 'App\Models\Application\Application');
    }
}

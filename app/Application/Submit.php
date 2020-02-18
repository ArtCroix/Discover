<?php

namespace App\Application;

use Illuminate\Database\Eloquent\Model;

class Submit extends Model
{
    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany('App\Application\Answer');
    }

    public function application()
    {
        return $this->belongsTo('App\Application\Application');
    }

    public function questions()
    {
        return $this->hasManyThrough('App\Application\Question', 'App\Application\Answer', 'submit_id', 'id', 'id', 'question_id');
    }
}

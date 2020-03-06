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
}

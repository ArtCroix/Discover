<?php

namespace App\Team;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $guarded = [];

    protected $table = "team_answers";

    public function post()
    {
        return $this->belongsTo('App\Team\Question');
    }
}

<?php

namespace App\Team;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = "team_questions";

    public function answers()
    {
        return $this->hasMany('App\Team\Answer');
    }

    public function application()
    {
        return $this->belongsTo('App\Team\Application');
    }

    public function rules()
    {
        return $this->hasMany('App\Rule', 'post_name', 'name');
    }
}

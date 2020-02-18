<?php

namespace App\Team;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = "team_applications";

    public function questions()
    {
        return $this->hasMany('App\Team\Question', 'application_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function rules()
    {
        return $this->hasManyThrough('App\Rule', 'App\Team\Question',  'application_id', 'post_name', 'id', 'name');
    }
}

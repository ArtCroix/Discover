<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    public function questions()
    {
        return $this->hasMany('App\Models\Application\Question', 'application_id');
    }

    public function submits()
    {
        return $this->hasMany('App\Models\Application\Submit', 'application_id');
    }

    public function teams()
    {
        return $this->hasMany('App\Models\Team', 'application_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

}

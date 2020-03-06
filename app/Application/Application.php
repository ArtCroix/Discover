<?php

namespace App\Application;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    public function questions()
    {
        return $this->hasMany('App\Application\Question', 'application_id');
    }

    public function submits()
    {
        return $this->hasMany('App\Application\Submit', 'application_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

}

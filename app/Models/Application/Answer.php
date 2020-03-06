<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo('App\Models\Application\Question');
    }

    public function submit()
    {
        return $this->belongsTo('App\Models\Application\Submit');
    }

}

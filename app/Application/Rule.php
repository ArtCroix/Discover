<?php

namespace App\Application;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    public function questions()
    {
        return $this->belongsTo('App\Application\Question');
    }
}

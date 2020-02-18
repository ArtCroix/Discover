<?php

namespace App\Team;

use Illuminate\Database\Eloquent\Model;

class Submit extends Model
{
    protected $guarded = [];

    protected $table = "team_submits";

    public function answers()
    {
        return $this->hasMany('App\Submit\Answer');
    }

    public function application()
    {
        return $this->belongsTo('App\Submit\Application');
    }
}

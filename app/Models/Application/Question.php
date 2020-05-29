<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $appends = ['input_name'];

    public function answers()
    {
        return $this->hasMany('App\Models\Application\Answer');
    }

    public function application()
    {
        return $this->belongsTo('App\Models\Application\Application');
    }

    public function rules()
    {
        return $this->hasMany('App\Models\Application\Rule', 'post_name', 'name');
    }

    public function getInputNameAttribute()
    {
        return $this->id . "#" . $this->name;
    }

    public function getAnswerAttribute()
    {
        return '';
    }
}

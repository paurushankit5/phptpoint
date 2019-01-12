<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subtutorial extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function slug()
    {
        return $this->belongsTo('App\Slug');
    }
    public function tutorial()
    {
        return $this->belongsTo('App\Tutorial');
    }
}

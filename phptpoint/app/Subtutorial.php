<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Laravel\Scout\Searchable;



class Subtutorial extends Model
{
    use SoftDeletes;
    //use Searchable;

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

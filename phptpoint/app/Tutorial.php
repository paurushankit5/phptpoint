<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Laravel\Scout\Searchable;



class Tutorial extends Model
{
    use SoftDeletes;
    //use Searchable;
    protected $dates = ['deleted_at'];

    public function slug()
    {
        return $this->belongsTo('App\Slug');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function subtutorial()
    {
        return $this->hasMany('App\Subtutorial')->orderBy('subtut_order', 'ASC');
    }
}

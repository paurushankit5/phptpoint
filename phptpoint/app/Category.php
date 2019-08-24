<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    protected $table = 'categories';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function tutorial()
    {
        return $this->hasMany('App\Tutorial');
    }
    public function categoryWithTutorials(){
    	return $this->hasMany('App\Tutorial')->where('category_id','<>',Null);
	}
}


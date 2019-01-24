<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
	use SoftDeletes;
    public function slug()
    {
        return $this->belongsTo('App\Slug');
    }
}

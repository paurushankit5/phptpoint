<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    public function tutorial()
    {
        return $this->hasOne('App\Tutorial');
    }
    public function subtutorial()
    {
        return $this->hasOne('App\Subtutorial');
    }
    
    public function project()
    {
        return $this->hasOne('App\Project');
    }
    public function page()
    {
        return $this->hasOne('App\Page');
    }
    
}

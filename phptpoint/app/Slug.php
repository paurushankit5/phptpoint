<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    public function tutorial()
    {
        return $this->hasOne('App\Tutorial');
    }
}

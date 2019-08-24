<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SidebarContent extends Model
{
     public function sidebar()
    {
        return $this->belongsTo('App\Sidebar');
    }
}

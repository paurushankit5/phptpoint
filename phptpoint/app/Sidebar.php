<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    public function sidebar_content()
    {
        return $this->hasMany('App\SidebarContent');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function hello(){
    	return "hello";
    }
    public function test(){
    	return "test";
    }
}

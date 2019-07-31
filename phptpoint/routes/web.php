<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/logout',function(){
	Auth::logout();
	return redirect('/');
});
Route::get('/','HomeController@index')->name('homepage');
Route::get('/home','HomeController@index')->name('home');


Route::get('/dashboard',function(){
	echo "user logged in";
});


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('/getprojectfile/{slug}/{id}', 'HomeController@getprojectfile')->name('home');

foreach(glob(dirname(__FILE__) . '/web/*.php') AS $file){
	require_once($file);
}


Route::any('/projects/{slug}', function($slug)
{
	$method = \DB::table('slugs')->where('slug',$slug)->first();
	if($method){
		//return $method->method_name;
		return \App::call('\App\Http\Controllers\\'.$method->method_name,[$method->id]);
	}
	else{
		abort(404);
	}
	
})->where('slug', '.*');


Route::any('/{slug}', function($slug)
{
	$method = \DB::table('slugs')->where('slug',$slug)->first();
	if($method){
		//return $method->method_name;
		return \App::call('\App\Http\Controllers\\'.$method->method_name,[$method->id]);
	}
	else{
		abort(404);
	}
	
})->where('slug', '.*');






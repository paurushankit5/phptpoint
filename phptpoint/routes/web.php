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

Auth::routes(['verify' => true]);

Route::get('/logout',function(){
	Auth::logout();
	return redirect('/');
});

Route::get('/change-password', 'UserController@changePassword')->middleware('auth');
Route::post('/change-password', 'UserController@updatePassword')->middleware('auth')->name('changePassword');

Route::get('/','HomeController@index')->name('homepage');
Route::get('/contact-us', 'HomeController@contactUs');
Route::post('/contact-us', 'HomeController@saveContactMessage');

Route::get('/dashboard',function(){
	return redirect('/phpadmin');
})->middleware('auth');

Route::get('/search', 'HomeController@search')->name('search');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});


Route::get('/blogs', 'BlogController@getLatestBlogs');

Route::get('/getprojectfile/{slug}/{id}', 'HomeController@getprojectfile');
Route::get('/gettutorialfile/{slug}/{id}', 'HomeController@gettutorialfile');
Route::get('/getsubtutorialfile/{slug}/{id}', 'HomeController@getsubtutorialfile');
Route::get('/loginToDownload/{slug}/{id}', 'HomeController@loginToDownload');

foreach(glob(dirname(__FILE__) . '/web/*.php') AS $file){
	require_once($file);
}

Route::any('/blog/{slug}', function($slug)
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






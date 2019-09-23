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


Route::get('/user/verify/{id}','UserController@verifyUser');

Route::get('/email/verify/{id}', function($id){
	echo date('Y-m-d H:i:s',$_GET['expires']);
	echo date('Y-m-d H:i:s');
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
Route::get('/getHints', 'HomeController@getHints')->name('getHints');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('/mail1', 'HomeController@sendmail');


Route::get('/blogs', 'BlogController@getLatestBlogs');
Route::get('/projects/', 'ProjectController@getAllProjects');

Route::get('/getprojectfile/{id}', 'HomeController@getprojectfile')->where('slug', '.*');
Route::get('/gettutorialfile/{id}', 'HomeController@gettutorialfile');
Route::get('/getsubtutorialfile/{id}', 'HomeController@getsubtutorialfile');
Route::get('/loginToDownload/{slug}', 'HomeController@loginToDownload')->where('slug', '.*');

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
		$method = \DB::table('slugs')->where('slug',$slug."/")->first();
		if($method){
			return \App::call('\App\Http\Controllers\\'.$method->method_name,[$method->id]);
		}
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
		$method = \DB::table('slugs')->where('slug',$slug."/")->first();
		if($method){
			return \App::call('\App\Http\Controllers\\'.$method->method_name,[$method->id]);
		}
		abort(404);
	}
	
})->where('slug', '.*');


Route::any('/{slug}', function($slug)
{
	$method = \DB::table('slugs')->where('slug',$slug)->first();
	if($method){
		return \App::call('\App\Http\Controllers\\'.$method->method_name,[$method->id]);
	}
	else{
		$method = \DB::table('slugs')->where('slug',$slug."/")->first();
		if($method){
			return \App::call('\App\Http\Controllers\\'.$method->method_name,[$method->id]);
		}
		abort(404);
	}
	
})->where('slug', '.*');






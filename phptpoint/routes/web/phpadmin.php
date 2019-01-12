<?php
Route::group(['middleware' => ['checkadmin'], 'prefix' => 'phpadmin'], function(){
	Route::get('', function(){
		return view('admin/dashboard');
	});
	Route::resource('/categories','CategoryController');
	Route::resource('/tutorials','TutorialController');
	Route::resource('/subtutorials','SubTutorialController');
});
?>
<?php
Route::group(['middleware' => ['checkadmin'], 'prefix' => 'phpadmin'], function(){
	Route::get('', function(){
		return view('admin/dashboard');
	});
	Route::resource('/categories','CategoryController');
	Route::resource('/tutorials','TutorialController');
	Route::get('tutorial/{id}/arrangesubtutorials','TutorialController@arrangesubtutorials')->name('arrangesubtutorials');
	Route::resource('/subtutorials','SubTutorialController');
	Route::resource('/projects','ProjectController');
	Route::resource('/pages','AdminPageController');
	Route::resource('/sidebars','SidebarController');
});
?>
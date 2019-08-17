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
	Route::resource('/adds','AddController');
	Route::resource('/blogs','BlogController');
	Route::resource('/users','UserController');
	Route::resource('/seo','SeoController');
	Route::resource('/enquiry','EnquiryController');

	Route::get('/mine',function(){
		echo request()->segment(1);
		//return view('admin/mine');
	});

	Route::post('/projects/uploadzip/{id}', 'ProjectController@uploadzip');
	Route::get('/projects/uploadzip/{id}', 'ProjectController@uploadzip');


	Route::post('/tutorials/uploadzip/{id}', 'TutorialController@uploadzip');
	Route::get('/tutorials/uploadzip/{id}', 'TutorialController@uploadzip');

	Route::post('/subtutorials/uploadzip/{id}', 'SubTutorialController@uploadzip');
	Route::get('/subtutorials/uploadzip/{id}', 'SubTutorialController@uploadzip');


	Route::post('/arrangesubtutorials', 'TutorialController@saveSubtutOrder');
	Route::post('/changeUserPassword/{user_id}', 'UserController@changeUserPassword');
});
?>
<?php
Route::group(['middleware' => ['checkadmin'], 'prefix' => 'admin'], function(){
	Route::get('', function(){
		return "admin url testing actual one";
		});

	
	});
?>
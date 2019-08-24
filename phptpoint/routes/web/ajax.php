<?php
Route::group(['middleware' => ['checkadmin'], 'prefix' => 'ajax'], function(){
	Route::get('/getalllistfromtable','AjaxController@getalllistfromtable');
});
?>
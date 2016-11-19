<?php

// route group for single estate operations
Route::group(['prefix' => '/имот'], function()
{
	// insert estate
	Route::post('добавяне', 'EstatesController@insertEstate');

	// upload estate images
	Route::post('снимки/добавяне', 'EstatesController@insertEstatePhotos');

	// delete estate
	Route::get('премахване/{id_kartoteka_n}', 'EstatesController@removeEstate');

	// view estate by slug
	Route::get('{estate_name}', 'EstatesController@viewEstate');

	// single estate by main parameters and id
	Route::get('{deal_type}/{estate_type}/{room_count}/{equipped}/{id}', 'EstatesController@view_single_estate');
});

// route group for operations with multiple estates
Route::group(['prefix' => '/имоти'], function()
{
	// all estates in database (currently returns a view + JSON data)
	Route::get('', 'EstatesController@get_all_estates');

	// all estates in database (currently returns only JSON data)
	Route::post('', 'EstatesController@get_all_estates_json');

	// estates by main parameters (currently returns a view + JSON data)
	Route::get('{deal_type}/{estate_type}/{room_count}/{equipped}', 'EstatesController@get_estates_by_main_parameters');

	// estates by main parameters (currently returns only JSON data)
	Route::post('{deal_type}/{estate_type}/{room_count}/{equipped}', 'EstatesController@get_estates_by_main_parameters_json');

	// estates by main parameters and additional filters (currently returns a view + JSON data)
	Route::get('{deal_type}/{estate_type}/{room_count}/{equipped}/{additional_filter}');

	// estates by main parameters and additional filters (currently returns only JSON data)
	Route::post('{deal_type}/{estate_type}/{room_count}/{equipped}/{additional_filter}');
});

Auth::routes();
Route::get('/home', 'HomeController@index');

/*
 * DEPRECATED ROUTES BELOW
 * ALL FUNCTIONS FOR ROUTES ABOVE RETURN VIEWS OR JSON DATA
 * WHICH IS TO BE PARSED BY THE FRONT-END.
*/

//filtered estates JsonWithMarkers(filter,map) in index.js:
//ajax calls this url to get all estates in json
Route::get('/allestates', 'MapController@allEstates');
//GET is for pasted url with filters 
Route::get('/имоти/filter/{filter}','MapController@getFilteredEstates');

Route::get('/test_basemap',function(){
	return view('test');
});
Route::get('/', function () {
	    return view('home');
	});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/kone', function () {
	    return view('home');
	});
	
});

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return View::make('SinglePage');
});

Route::group(['prefix' => 'api'], function () {
    Route::post('/auth/login', array('middleware' => 'csrf', 'uses' => 'AuthController@login'));
    Route::get('/auth/status', 'AuthController@status');
	Route::get('/auth/secrets','AuthController@secrets');
	Route::get('/auth/token','AuthController@token');
	Route::get('/auth/logout', 'AuthController@logout');
	Route::post('/auth/register', array('uses' => 'AuthController@register'));  //api endpoint to register a user
	Route::post('/auth/register/validate/username', array('uses' => 'AuthController@validateUsername'));
	Route::post('/auth/register/validate/email', array('uses' => 'AuthController@validateEmail'));
	
	//api endpoint to retrieve all the listing for a particlar institution id
    Route::get('/dashboard/get/listings', 'ListingController@getlistingsforinstitution');

    //api endpoint to retrieve all the institutions
    Route::get('/dashboard/get/institutions', 'ListingController@getinstitutions');
    
    //api endpoint to retrieve all the courses for a particlar institution id
    Route::get('/dashboard/get/courses', 'LibraryController@getuniversitycourses');

    //api endpoint to retrieve all the books for a particlar course
    Route::get('/dashboard/get/books', 'LibraryController@getbooksforcourse');
    
    Route::get('/register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'RegistrationController@confirm'
]);
    
    
});


/*Route::filter('csrf', function () {
    if (Session::token() != Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

Route::filter('csrf_json', function () {
	print_r(Request::get('csrf_token'));
    if (Session::token() != Input::get('csrf_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
*/
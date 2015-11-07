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
Route::resource("/driverrides/driver.datetime", "DriverRideController");
Route::resource("/passengers/passenger.driver.datetime", "PassengerController");

/*
 * Rendering static pages
 *************************/
Route::get('/welcome', ['uses' => 'UserController@welcome']);
Route::get('/', ['uses' => 'UserController@dashboard']);
Route::get('/adminaccess', ['uses' => 'UserController@giveMeAdminAccess']);

/*
 * Forms and endpoints 
 * specific to the app
 *************************/
Route::get('/signup', ['uses' => 'AccountController@create']);
Route::get('/me', ['uses' => 'AccountController@show']);
Route::get('/me/edit', ['uses' => 'AccountController@edit']);
Route::post('/me/update', ['uses' => 'AccountController@update']);
Route::post('/accounts', ['uses' => 'AccountController@store']);

/* 
 * Admin routes 
 *************************/
Route::group(['middleware' => 'admin'], function()
{
	/* Person routes */
	Route::resource('persons', 'PersonController', ['only' => ['index', 'show', 'edit', 'update', 'delete']]);
	
	/* Profile routes */
	Route::resource('profiles', 'ProfileController', ['only' => ['index', 'show', 'edit', 'update']]);
	Route::delete('/profiles/{email}/{userid}', ['uses' => 'ProfileController@destroy']);

	/* Car routes */
	Route::resource('cars', 'CarController', ['only' => ['index', 'show', 'edit', 'update', 'delete']]);

	/* Rides & Drivers routes */
	Route::resource('driverrides', 'DriverRideController', ['only' => ['index', 'show', 'edit', 'update', 'delete']]);

	/* Passengers routes */
	Route::resource('passengers', 'PassengerController', ['only' => ['index', 'show', 'edit', 'update', 'delete']]);

});

/* 
 * Facebook routes 
 *************************/
Route::get('/login/facebook', ['uses' => 'UserController@redirectToFacebook']);
Route::get('/login/facebook/callback', ['uses' => 'UserController@handleFacebookCallback']);

/* 
 * Session routes
 *************************/
Route::post('/login', ['uses' => 'UserController@login']);
Route::get('/logout', ['uses' => 'UserController@logout']);
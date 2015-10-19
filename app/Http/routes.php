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

/*
 * Rendering static pages
 *************************/
Route::get('/welcome', ['uses' => 'UserController@welcome']);
Route::get('/', ['uses' => 'UserController@home']);

/*
 * Forms and endpoints 
 * specific to the app
 *************************/
Route::get('/signup', ['uses' => 'UserController@create']);
Route::get('/me', ['uses' => 'UserController@show']);
Route::post('/accounts', ['uses' => 'UserController@store']);

/* 
 * Profile routes 
 *************************/
Route::get('/profiles/new', ['uses' => 'ProfileController@create']);
Route::get('/profiles/{email}', ['uses' => 'ProfileController@show']);
Route::post('/profiles', ['uses' => 'ProfileController@store']);

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
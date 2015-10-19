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
Route::get('/', ['uses' => 'UserController@dashboard']);

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
 * Profile routes 
 *************************/
Route::group(['middleware' => 'admin'], function()
{
    // Route::resource('todo', 'TodoController', ['only' => ['index']]);
    Route::resource('persons', 'PersonController');
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
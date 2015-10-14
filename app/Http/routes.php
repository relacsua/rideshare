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

Route::get('/', ['uses' => 'UserController@welcome']);
// Route::post('/', ['uses' => 'UserController@store']);
Route::get('/login/facebook', ['uses' => 'UserController@redirectToFacebook']);
Route::get('/login/facebook/callback', ['uses' => 'UserController@handleFacebookCallback']);

Route::get('/students/{name}', ['uses' => 'SampleController@index']);
Route::get('sample', ['uses' => 'SampleController@sample']);
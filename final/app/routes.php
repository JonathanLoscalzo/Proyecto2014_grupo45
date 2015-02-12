<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// TODO: COMO PASO PARAMETROS AL CONTROLLER?

Route::get('/','HomeController@index', function()
{
	//return View::make('HomeController.index');
});

Route::get('login', 'LoginController@showLogin');

Route::post('login', ['uses' => 'LoginController@dologin'] );

Route::get('backend', function()
{
    return View::make('LoginController.index-backend');
});

Route::get('logout', 'LoginController@logout' );




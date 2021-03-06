<?php

Validator::extend('notLogged', function($attribute, $value, $parameters) {
    return $value != Auth::User()->userID;
});

Validator::extend('passcheck', function ($attribute, $value, $parameters) {
    $user = DB::table($parameters[0])->where($parameters[2], $parameters[3])->first([$parameters[1]]);
    if (Hash::check($value, $user->{$parameters[1]})) {
        return true;
    } else {
        return false;
    }
});



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

Route::get('/', 'HomeController@index', function() {
    //return View::make('HomeController.index');
});




Route::get('login', 'LoginController@showLogin');

Route::post('login', ['uses' => 'LoginController@dologin']);

Route::when('backend/*', 'csrf', array('post'));

Route::group(array('before' => 'auth'), function() {
    Route::get('backend', function() {
        return View::make('LoginController.index-backend');
    });

    Route::get('logout', 'LoginController@logout');

    Route::group(array('before' => 'role-admin'), function() {
        Route::get('backend/usuarios', 'UsuarioController@index');

        Route::post('backend/usuarios/add', 'UsuarioController@add');

        Route::get('backend/usuarios/edit/{userID}', ['uses' => 'UsuarioController@edit']);

        Route::post('backend/usuarios/edit', 'UsuarioController@editView');

        Route::get('backend/usuarios/remove/{userID}', [ 'uses' => 'UsuarioController@remove']);
    });

    Route::group(['prefix' => 'backend/Estadisticas'], function() {
        Route::get('/', ['uses' => 'EstadisticasController@index']);
        Route::post('/uno', ['before' => 'csrf', 'uses' => 'EstadisticasController@uno']);
        Route::post('/dos', ['before' => 'csrf', 'uses' => 'EstadisticasController@dos']);
        Route::post('/tres', ['before' => 'csrf', 'uses' => 'EstadisticasController@tres']);
        Route::post('/exportarpdf2', ['uses' => 'EstadisticasController@exportarPDF2']);
    });
});









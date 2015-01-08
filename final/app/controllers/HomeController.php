<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
                $cant = count(explode("/", $_SERVER['REQUEST_URI'])) - 2;
                $var = str_repeat("../", $cant);
                View::share('server', $var);
		return View::make('HomeController.index');
	}

}

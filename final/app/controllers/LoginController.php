<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginController extends BaseController {
    
    // TODO: HAY QUE VER COMO SE HACE EL LOGIN CON ESTE FRAMEWORK
    // TODO: EL SCRATCH FUE SACADO DE https://github.com/scotch-io/simple-laravel-login-authentication/blob/master/app/controllers/HomeController.php
    	public function doLogin()
	{
		// validate the info, create rules for the inputs
		$rules = array(
			'email'    => 'required|email', // make sure the email is an actual email
			'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
		);
		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);
		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return Redirect::to('login')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {
			// create our user data for the authentication
			$userdata = array(
				'email' 	=> Input::get('email'),
				'password' 	=> Input::get('password')
			);
			// attempt to do the login
			if (Auth::attempt($userdata)) {
				// validation successful!
				// redirect them to the secure section or whatever
				// return Redirect::to('secure');
				// for now we'll just echo success (even though echoing in a controller is bad)
				echo 'SUCCESS!';
			} else {
				// validation not successful, send back to form
				return Redirect::to('login');
			}
		}
	}
    
    public function backend() {
        /* verificar si la sesion està iniciada? Todos pueden acceder a este */
        if (parent::backendIsLogged()) {
            $view = new BackEndView();
            $view->index();
        }
    }
    
    
}


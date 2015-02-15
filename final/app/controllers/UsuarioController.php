<?php

class UsuarioController extends BaseController {

    public function add() {
        $rules = array(
			'username'    => 'required|alphaNum|unique:user',
			'pass' => 'required|alphaNum|min:3', // password can only be alphanumeric and has to be greater than 3 characters
                        'pass2' => 'required|alphaNum|same:pass',
        );  // validation rules
        $messages = array(
              'unique' => Input::get('username').' ya se encuentra registrado',
              'required' => 'El :attribute es requerido para el login',
              'alphaNum' => ':attribute debe ser alfanumerico',
        );
	// run the validation rules on the inputs from the form
	$validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::to('backend/usuarios')->withErrors($validator);
        }
        else {
            $user = new User();
            $user->username = Input::get('username');
            $user->roleID = Input::get('roleID');
            $user->pass = Hash::make(Input::get('pass'));
            $user->save();
            $messages = 'Se ha registrado el usuario '.$user->username.' correctamente';
            return Redirect::to('backend/usuarios')->with('message', $messages);
        }
        
        
    }

    public function edit($userID) {
                    
        $rules = array(
                        'userID' => 'integer|notLogged|exists:user|required',
        );  // validation rules
        $messages = array(
              'exists' => 'El usuario no existe',
              'not_logged' => 'El usuario que desea editar se encuentra logueado',
        );
	// run the validation rules on the inputs from the form
	$validator = Validator::make([
            'userID' => $userID] , $rules, $messages);
        if ($validator->fails()) {
            return Redirect::to('backend/usuarios')->withErrors($validator);
        }
        else {
            $user = User::find($userID);
            $roles = Role::all();
            return View::make
                    ('UsuarioController.EditViewUsuarios')->with(array('usuario'=> $user,
                                                                       'roles' => $roles));
        }

        
    }

    public function editView() {
        $rules = array(
                        'userID' => 'integer|notLogged|exists:user|required',
                        'username' => 'unique:user,username, '.Input::get('userID').',userID|min:3|alphaNum',
                        'pass' => 'passcheck:user,pass,userID,'.Input::get('userID'),
                        'pass2' => 'alphaNum',
        );  // validation rules
        $messages = array(
              'exists' => 'El usuario no existe',
              'not_logged' => 'El usuario que desea editar se encuentra logueado',
              'passcheck' => 'El password antiguo no coincide',
              'unique' => 'El nombre de usuario '.Input::get('username').' ya se encuentra en uso',
        );
        // run the validation rules on the inputs from the form
	$validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::to('backend/usuarios')->withErrors($validator);
        }
        else {
            $user = User::find(Input::get('userID'));
            $user->username = Input::get('username');
            $user->pass = Hash::make(Input::get('pass2'));
            $user->roleID = Input::get('roleID');
            $user->save();
            return Redirect::to('backend/usuarios')->with('message',
                    'El usuario se ha editado correctamente');
        }
    }

    public function remove($userID) {
        
        $rules = array(
                        'userID' => 'integer|notLogged|exists:user',
        );  // validation rules
        $messages = array(
              'exists' => 'El usuario no existe',
              'not_logged' => 'El usuario que desea editar se encuentra logueado',
        );
	// run the validation rules on the inputs from the form
	$validator = Validator::make([
            'userID' => $userID] , $rules, $messages);
        if ($validator->fails()) {
            return Redirect::to('backend/usuarios')->withErrors($validator);
        }
        else {
            $user = User::find($userID);
            $user->delete();
            return Redirect::to('backend/usuarios')->with('message', 'Se ha eliminado correctamente');
        }
    }

    public function index() {
        $users = User::all();
        $roles = Role::all();
        return  View::make('UsuarioController.usuarios', array('usuario' => $users,
            'roles' => $roles));

    }
}


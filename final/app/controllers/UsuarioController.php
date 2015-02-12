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

    public function edit($post) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $data = $post->getParams(); // obtenemos Los parametros
                $username = $data['username'];
                $userID = $data['userID'];
                $user = UserRepository::getInstance()->getByID($userID);
                $userActual = UserRepository::getInstance()->getByUsername($username);
                // CODE REFACTORIZADO, se puede transladar a otros casos.
                if ((!$userActual) || ($userActual->getUserID() == $userID)) {
                    $entidad = new UserModel(
                            $userID, $username, $user->getPass(), $data["roleID"]);
                    UserRepository::getInstance()->edit($entidad); /* validar si el roleID existe. */
                    $_SESSION["message"] = new MessageService("modificationSuccess", ["usuario con nombre " . $data['username']]);
                } else {
                    $_SESSION["message"] = new MessageService("modificationErrorExist", ["usuario", "username (" . $data['username'] . ")"]);
                }
            }
            $this->redirect();
        }
    }

    public function editView($id) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $usuario = UserRepository::getInstance()->getByID($id);
                if ($usuario) {
                    $roles = RoleRepository::getInstance()->getAll();
                    $view = new BackEndView();
                    $view->editViewUsuarios($usuario, $roles); // si no devuelve nada esta vista se encarga
                } else {
                    $_SESSION["message"] = new MessageService("modificationErrorNotExist", ["Usuario"]);
                    $this->redirect(); 
                }
                
            }
        }
    }

    public function remove($id) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $userInfo = UserRepository::getInstance()->getByID($id);
                if ($userInfo) {
                    UserRepository::getInstance()->remove($id);
                    $_SESSION["message"] = new MessageService("removeSucess", ["entidad receptora"]);
                } else {
                    $_SESSION["message"] = new MessageService("removeErrorNotExist", ["entidad receptora"]);
                }
                $this->redirect();
            }
        }
    }

    public function index() {
        $users = User::all();
        $roles = Role::all();
        return  View::make('UsuarioController.usuarios', array('usuario' => $users,
            'roles' => $roles));

    }
}


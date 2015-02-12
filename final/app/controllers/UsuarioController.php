<?php

class UsuarioController extends BaseController {

    public function create($post) {
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


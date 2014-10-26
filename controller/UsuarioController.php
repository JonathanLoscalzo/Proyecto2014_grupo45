<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioController
 *
 * @author loscalzo
 */
class UsuarioController extends Controller {

    private static $instance = null;

    protected function redirect() {
        parent::redirect("usuarios");
    }

    public function create($post) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $data = $post->getParams(); // obtenemos Los parametros
                /* VALIDAR PARAMETROS */
                $username = $data['username'];
                if (!UserRepository::getInstance()->exist($username)) {
                    $entidad = new UserModel(
                            null, $data["username"], $data["pass"], $data["roleID"]);
                    UserRepository::getInstance()->add($entidad);

                    $_SESSION["message"] = new MessageService("createSuccess", ["USERNAME " . $data['username']]);
                } else {
                    // YA EXISTE LA ENTIDAD
                    $_SESSION["message"] = new MessageService("createErrorExist", ["USERNAME " . $data['username']]);
                }
                $this->redirect();
            }
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
                $userInfo = EntidadReceptoraRepository::getInstance()->getByID($id);
                if ($userInfo) {
                    EntidadReceptoraRepository::getInstance()->remove($id);
                    $_SESSION["message"] = new MessageService("removeSucess", ["entidad receptora"]);
                } else {
                    $_SESSION["message"] = new MessageService("removeErrorNotExist", ["entidad receptora"]);
                }
                $this->redirect();
            }
        }
    }

    public function index() {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
// Se traen todos los alimentos (tipos) y todos los detalles
// los alimentos se traen para poder completar la lista de tipos
                $usuarios = UserRepository::getInstance()->getAll();
                $roles = RoleRepository::getInstance()->getAll();
                $view = new BackEndView();
                $view->usuarios($usuarios, $roles);
            }
        }
    }

//put your code here
}

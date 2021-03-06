<?php

include_once("Controller.php");
include_once("model/UserModel.php");
include_once("repository/UserRepository.php");
include_once("repository/PDOrepository.php");
include_once("controller/LoginStatusClass.php");

class LoginController extends Controller {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function startSession() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    private function destroySession() {
        self::startSession();
        if (isset($_SESSION)) {
            unset($_SESSION['username']);
            unset($_SESSION['roleID']);
            session_destroy();
        }
    }

    public function isSessionStart() {
        self::startSession();
        return isset($_SESSION['username']);
    }

    public function login($user, $pass) {
        /* deberia validar en la base de datos */

        $aux = self::createSession($user, $pass);

        switch ($aux) {
            case 0:
            case 1:
                $view = new BackEndView();
                $_SESSION["message"] = new MessageService("accessGranted", [$_SESSION["username"]]);
                $view->index();
                break;
            case 2:
                $view = new FrontEndView();
                $_SESSION["message"] = new MessageService("wrongPassOrUser", []);
                $view->index();
                break;
        }
    }

    public function backend() {
        /* verificar si la sesion està iniciada? Todos pueden acceder a este */
        if (parent::backendIsLogged()) {
            $view = new BackEndView();
            $view->index();
        }
    }

    private function createSession($userName, $pass) {
        /*
         * 	Esta funcion crea una sesion de usuario.
         * 	Si puede iniciar sesion, conecta
         * 	
         */
        self::startSession();
        if (!self::isSessionStart()) {
            $actualUser = UserRepository::getInstance()->getUser($userName, $pass);
            if ($actualUser != false) {
                $_SESSION['username'] = $actualUser->getUsername();
                $_SESSION['roleID'] = $actualUser->getRoleID();
                return 0;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

    public function logout() {
        self::startSession();
        $_SESSION["message"] = new MessageService("closeSession", [$_SESSION["username"]]);
        self::destroySession();
        self::startSession();
        $view = new FrontEndView();
        $view->index();
    }

    public function create($entidad) {
        
    }

    public function edit($entidad) {
        
    }

    public function editView($id) {
        
    }

    public function remove($id) {
        
    }

}

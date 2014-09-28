<?php

include_once('LoginController.php');
include_once('LoginStatusClass.php');
include_once("model/ParamsClass.php");
include_once("controller/MessageService.php");

abstract class Controller {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    protected function __construct() {
        
    }

    protected function backendIsLogged() {
        /* falta implementar funcionalidad */

        $loginController = LoginController::getInstance();
        $loginController->startSession();

        if ($loginController->isSessionStart()) {
            return true;
        } else {
            $view = new FrontEndView();
            $view->index(LoginStatus::call(3));
            return false;
        }
    }

    /* deberia tener una interfaz ? */

    abstract public function create($entidad);

    abstract public function edit($entidad);

    abstract public function remove($id);

    abstract public function editView($id);
}

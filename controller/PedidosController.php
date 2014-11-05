<?php

include_once('Controller.php');
include_once("repository/PDOrepository.php");
include_once("controller/RoleService.php");


class PedidosController extends Controller {

    private static $instance = null;

    protected function redirect() {
        parent::redirect("ConfeccionPedidos");
    }
    
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    
    
    public function edit($id) {
        
    }
    public function create($entidad) {
        
    }
    public function remove($id) {}
    public function editView($id) {
    } 

    public function index() {
        if (parent::backendIsLogged()) {
               if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                        $view = new BackEndView();
                        $view->Pedidos();
                    }
                }
        }
}
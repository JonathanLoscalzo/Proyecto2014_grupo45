<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfiguracionController
 *
 * @author dante
 */
class ConfiguracionController extends Controller {
    //put your code here
    
    private static $instance = null;

    protected function redirect() {
        parent::redirect("configuracion");
    }

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function editView($id) {
        
    }
    public function edit($obj) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $datos = $obj->getParams();
                ConfiguracionRepository::getInstance()->editDiasVencimiento($datos['dias-vencimiento']);
                BancoRepository::getInstance()->edit(new BancoModel($datos['id'], $datos['nombre'], $datos['ubicacion'], $datos['lat'], $datos['long']));
              
            }
            $this->redirect();
        }
        
    }
    public function remove($id) {
        
    }
    public function create($obj) {
        
    }
    public function index() {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $view = new BackEndView();
                $banco = BancoRepository::getInstance()->getAll();
                $configuracion = ConfiguracionRepository::getInstance()->getAll();
                $view->configuracion($banco[0], $configuracion[0]);
            }
        }
        
    }
    
    
}

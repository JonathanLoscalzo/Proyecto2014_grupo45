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
        
    }

    public function edit($post) {
        
    }

    public function editView($id) {
        
    }

    public function remove($id) {
        
    }

    public function index() {
        if (parent::backendIsLogged()) {
            //if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
// Se traen todos los alimentos (tipos) y todos los detalles
// los alimentos se traen para poder completar la lista de tipos
                $usuarios = UsuarioRepository::getInstance()->getAll();
                $roles = RoleRepository::getInstance()->getAll();
                $view = new BackEndView();
                $view->usuarios($usuarios, $roles);
           // }
        }
    }
//put your code here
}

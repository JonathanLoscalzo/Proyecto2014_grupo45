<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RoleController
 *
 * @author loscalzo
 */
include_once("controller/MessageService.php");

class RoleService {
    /*  Se tendrá una interesante estructura indexada por roles, 
     *  en la que tendrá un arreglo que indicarán todas las funciones 
     *  en las que tiene permiso entrar ese Rol
     *  
     *  version 1 -> lo hacemos a manopla. Pero se podría tener estos datos en el servidor
     *  Las únicas funciones que se tendrán en cuenta son las de los controladores ya que, 
     *  uno por URI no puede acceder a la base de datos mas que a travès del controlador.
     *  Los valores del arreglo valor de rol (al que apunta rol) serán de este estilo : 
     *  ClaseControladora:FuncionClaseControladora. Esto se logra con las variables mágicas 
     *  __CLASS__:__FUNCTION__.
     * 
     *  version 2 -> se deberian tener las funciones y los roles en la base de datos.
     *  Obtener estos roles cuando se necesitan y guardarlos. Un singleton vendría bien.
     *  Accede a la base, se trae los datos y estos no cambian. (no es muy querido
     *  el patrón singleton, sobretodo para los testers.
     * 
     */

    private function redirect() {
        $cant = count(split("/", $_SERVER['REQUEST_URI'])) - 2;
        $var = str_repeat("../", $cant);
        header("Location: ./backend/" . $var);
    }

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    private $arrayRole;

    public function hasRolePermission($role, $functionName) {
        $array = $this->getRoles();
        $answer = in_array($functionName, $array[$role]);
        if (!$answer) {
            $_SESSION["message"] = new MessageService("permissionDenied", []);
            $this->redirect();
        }
        return $answer;
    }

    /* el usuario 2 todavia no tiene posibilidad de hacer nada */

    public function __construct() {
        $this->arrayRole = array(
            1 => [
                "DonanteController:index",
                "DonanteController:remove",
                "DonanteController:edit",
                "DonanteController:editView",
                "DonanteController:create",
                "EntidadReceptoraController:index",
                "EntidadReceptoraController:remove",
                "EntidadReceptoraController:edit",
                "EntidadReceptoraController:editView",
                "EntidadReceptoraController:create",
                'EnviosController:index', // ok?
                "AlimentoController:index",
                "AlimentoController:remove",
                "AlimentoController:edit",
                "AlimentoController:editView",
                "AlimentoController:create",
                "AlimentoController:listarAlimentos",
                "UsuarioController:index",
                "UsuarioController:edit",
                "UsuarioController:editView",
                "UsuarioController:listarUsuarios",
                "UsuarioController:remove",
                "UsuarioController:create",
            ],
            2 => [],
            3 => ["AlimentoController:listarAlimentos"]
        );
    }

    private function getRoles() {
        return $this->arrayRole;
    }

}

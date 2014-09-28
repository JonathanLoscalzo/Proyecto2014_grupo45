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
     *  el patrón singleton.
     * 
     */

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
        return in_array($functionName, $array[$role]);
    }

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
                "AlimentoController:index",
                ],
            2 => [" "],
            3 => ["AlimentoController:index"]
        );
    }

    public function getRoles() {
        return $this->arrayRole;
    }

}

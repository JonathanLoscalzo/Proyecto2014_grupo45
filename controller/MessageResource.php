<?php

/*
  Esto sirve para la internacionalizacion.
 *  Guardo los posibles mensajes como claves.
 *  y el valor es un string con valor para completar
 * 
 */

/**
 * Description of MessageResource
 *
 * @author loscalzo
 */
class MessageResource {
    /*
     *  string vsprintf ( string $format , array $args )
      Opera como sprintf() pero acepta un array de argumentos, en lugar de un número variable de argumentos.
     *  print vsprintf("%04d-%02d-%02d", array(1988, "08", "01")); // 1988-08-01
     */

    private $resources = array(
        "createErrorExist" => ["El %s se encuentra repetido, no puede darse de alta.", "error"],
        "createSuccess" => ["El %s se ha creado correctamente.", "success"],
        "modificationErrorExist" => ["El %s que intenta modificar tiene %s repetida, que es identificatorio.", "error"],
        "modificationErrorNotExist" => ["El %s que intenta modificar no existe.", "error"],
        "modificationSuccess" => ["El %s se ha modificado correctamente.", "success"],
        "removeErrorNotExist" => ["El %s que intenta eliminar no existe.", "error"],
        "removeSucess" => ["El %s se ha eliminado correctamente", "success"],
        "permissionDenied" => ["Ud. no tiene permiso para entrar aquí.", "error"],
        "accessGranted" => ["Bienvenido %s ! ", "success"],
        "repeatAccessGranted" => ["UD ya inició sesión como %s, no puede hacerlo dos veces. Debe cerrar sesión.", "success"],
        "wrongPassOrUser" => ["Usuario o contraseña erróneos", "error"],
        "closeSession" => ["Sesión finalizada, Hasta luego %s!", "success"],
        "needLogin" => ["Necesita iniciar sesión para ingresar a estas funciones","error"]
    );
    
    public function getResource($key){
        return $this->resources[$key];
    }

}

<?php
/*
 *  Clase helper para obtener los parametros. 
 * 
 * 
 */
class Params {
    private static $instance = null;
    private $paramsArray;
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function __construct($params) {
        $this->paramsArray = $params;
    }
    public function getParams () {
        return $this->paramsArray;
        
    }
    public function setParams () {
        
    }
    
    
}


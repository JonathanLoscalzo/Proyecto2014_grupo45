<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfiguracionRepository
 *
 * @author dante
 */

include_once("model/ConfiguracionModel.php");

class ConfiguracionRepository extends PDOrepository {
    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function editDiasVencimiento($int) {
        $sql = "UPDATE fecha_configuracion SET dias=?";
        $args = [$int];
        $mapper = function($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    public function getAll() {
        $sql = "SELECT * FROM fecha_configuracion";
        $args = [];
        $mapper = function($row) {
            return new ConfiguracionModel($row['dias']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    public function exist($id) {
        
    }
    public function getByID($id) {
        
    }
    public function add($obj) {
        
    }
    public function edit($obj) {
        
    }
    public function remove($id) {
        
    }
    
}

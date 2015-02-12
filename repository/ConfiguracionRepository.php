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
include_once("model/OAuthModel.php");

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
    public function getAllOauth() {
        $sql = "SELECT * FROM configuracion";
        $args = [];
        $mapper = function($row) {
            return new OAuthModel($row['API-Key'], $row['API-Secret'],
                    $row['OAuth-Token'], $row['OAuth-Secret']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False;
        return $ret;
    }
    public function editOAuth($user, $pass, $token_id, $token_secret) {
        if (!$this->getAllOauth()){// atajo porque ni ganas de crear un add, si no hay OAuth configurado
            // primera inicializacion, se utiliza un INSERT, sino se hace UPDATE.
            $sql = "INSERT INTO `configuracion`(`API-Key`, `API-Secret`, `OAuth-Token`, `OAuth-Secret`) "
                    . "VALUES (?,?,?,?)";
        }
        else {
            $sql = "UPDATE `configuracion` SET `API-Key`=?"
                    . ",`API-Secret`=?,"
                    . "`OAuth-Token`=?,"
                    . "`OAuth-Secret`=? WHERE 1";
        }
        $args = [$user, $pass, $token_id, $token_secret];
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

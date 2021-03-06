<?php

class NecesidadEntidadRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function getByID($id) {
        $sql = "SELECT * FROM necesidad_entidad WHERE Id=?";
        $args = [$id];
        $mapper = function ($row) {
            return new NecesidadEntidadModel($row['Id'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0]; // deberia devolver solo 1. 
    }

    public function add($necesidadEntidad) {
        $sql = "INSERT INTO necesidad_entidad(descripcion) VALUES(?)";
        $args = $necesidadEntidad->getArray()['descripcion'];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function getAll() {
        $sql = "SELECT * FROM necesidad_entidad";
        $args = [];
        $mapper = function ($row) {
            return new NecesidadEntidadModel($row['Id'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function edit($obj) {
        
    }

    public function exist($id) {
        
    }

    public function remove($id) {
        
    }

}

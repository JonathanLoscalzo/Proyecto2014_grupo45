<?php

class EstadoEntidadRepository extends PDORepository{
    private static $instance = null;
    
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function getByID($id) {
        // getByID
        $sql = "SELECT * FROM estado_entidad WHERE id=?";
        $args = [$id];
        $mapper = function ($row) {
            return new EstadoEntidadModel($row['Id'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer; // TODO: CORREGIR FALTA EL IF
    }
    public function add($estadoEntidad) {
        $sql = "INSERT INTO estado_entidad(descripcion) VALUES(?)";
        $args = $estadoEntidad->getArray()['descripcion'];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    public function getAll() {
        $sql = "SELECT * FROM estado_entidad";
         $args = [];
        $mapper = function ($row) {
            return new EstadoEntidadModel($row['Id'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    
}
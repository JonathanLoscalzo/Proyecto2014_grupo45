<?php

class ServicioEntidadRepository extends PDORepository{
    private static $instance = null;
    
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function getByID($id) {
        // getByID
        $sql = "SELECT * FROM servicio_prestado WHERE Id=?";
        $args = [$id];
        $mapper = function ($row) {
            return new ServicioEntidadModel($row['Id'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0];
    }
    public function add($estadoEntidad) {
        $sql = "INSERT INTO estado_entidad(descripcion) VALUES(?)";
        $args = $estadoEntidad->getArray()['descripcion'];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    public function getAll() {
        $sql = "SELECT * FROM servicio_prestado";
        $args = [];
        $mapper = function ($row) {
            return new ServicioEntidadModel($row['Id'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    
}


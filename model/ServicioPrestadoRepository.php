<?php

class ServicioEntidadRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public static function getByID($id) {
        // getByID
        $sql = "SELECT * FROM servicio_prestado WHERE id=?";
        $args = array($id);
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return new ServicioEntidadModel($answer['id'], $answer['descripcion']);
    }

    public function add($estadoEntidad) {
        $sql = "INSERT INTO estado_entidad(descripcion) VALUES(?)";
        $args = $estadoEntidad->getArray()['descripcion'];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public static function getAll() {
        $sql = "SELECT * FROM servicio_prestado";
        $args = "";
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

}
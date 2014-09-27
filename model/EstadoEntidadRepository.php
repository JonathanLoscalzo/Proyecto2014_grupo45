<?php

class EstadoEntidadRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public static function getByID($id) {
        // getByID
        $sql = "SELECT * FROM estado_entidad WHERE id=?";
        $args = array($id);
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return new EstadoEntidadModel($answer['id'], $answer['descripcion']);
    }

    public function add($estadoEntidad) {
        $sql = "INSERT INTO estado_entidad(descripcion) VALUES(?)";
        $args = $estadoEntidad->getArray()['descripcion'];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public static function getAll() {
        $sql = "SELECT * FROM estado_entidad";
        $args = "";
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

}
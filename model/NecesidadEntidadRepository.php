<?php

class NecesidadEntidadRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public static function getByID($id) {
        $sql = "SELECT * FROM necesidad_entidad WHERE id=?";
        $args = array($id);
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return new NecesidadEntidadModel($answer['id'], $answer['descripcion']);
    }

    public function add($necesidadEntidad) {
        $sql = "INSERT INTO necesidad_entidad(descripcion) VALUES(?)";
        $args = $necesidadEntidad->getArray()['descripcion'];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public static function getAll() {
        $sql = "SELECT * FROM necesidad_entidad";
        $args = [];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

}



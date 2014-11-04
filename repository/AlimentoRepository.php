<?php

include_once("repository/PDOrepository.php");
include_once("model/AlimentoModel.php");

class AlimentoRepository extends PDORepository {

    // TODO: no deberia pasarle un objeto como parametro el controlador en vez de
    // un array o un parametro suelto? No sería mas comodo y mas prolijo?
    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function add($alimento) {

        $sql = "INSERT INTO alimento VALUES(?, ?)";
        $args = $alimento->getArray();
        $mapper = function($row) {
            
        }; // que carajo hace mapper cuando no se
        // necesita?
        $answer = $this->queryList($sql, $args, $mapper);
    }

    public function get($codigo) {
        $sql = "SELECT * FROM alimento WHERE alimento.codigo = ?";
        $args = [$codigo];
        $mapper = function($row) {
            return new AlimentoModel($row['codigo'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False;
        return $ret;
    }

    public function edit($alimento) {
        // por ahora no permito cambiarle el codigo, desp se verá si es necesario
        $sql = "UPDATE alimento SET descripcion=? WHERE alimento.codigo = ?";
        $args = $alimento->getArray();
        $mapper = [];
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function remove($codigo) {
        $sql = "DELETE FROM alimento WHERE alimento.codigo = ?";
        $args = ($codigo);
        $mapper = function($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False;
        return $ret;
    }

    public function getAll() {
        $sql = "SELECT * FROM alimento";
        $args = [];
        $mapper = function($row) {
            return new AlimentoModel($row['codigo'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function getByID($codigo) {
        $sql = "SELECT * FROM alimento WHERE alimento.codigo = ?";
        $args = [$codigo];
        $mapper = function($row) {
            return new AlimentoModel($row['codigo'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False;
        return $ret;
    }

    public function exist($id) {
        
    }

}

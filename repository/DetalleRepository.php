<?php
include_once("repository/PDOrepository.php");

class DetalleRepository extends PDORepository {

    // TODO: no deberia pasarle un objeto como parametro el controlador en vez de
    // un array o un parametro suelto? No sería mas comodo y mas prolijo?
    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function add($detalle) {
        $sql = "INSERT INTO detalle_alimento(alimento_codigo, fecha_vencimiento, contenido, peso_unitario, stock, reservado) VALUES(?, ?, ?, ?, ?, ?)";
        $args = $detalle->getArray();
        array_shift($args); // corremos el null
        array_pop($args); // quitamos el model sino da error de string parse
        $mapper = function($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function get($id) {
        $sql = "SELECT * FROM detalle_alimento WHERE Id = ?";
        $args = [$id];
        $mapper = function($row) {
            return new DetalleModel($row['Id'], $row['alimento_codigo'], $row['fecha_vencimiento'], $row['contenido'], $row['peso_unitario'], $row['stock'], $row['reservado']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False; // short if, mas comodo
        return $ret;
    }

    public function edit($detalle) {
        // por ahora no permito cambiarle el codigo, desp se verá si es necesario
        $sql = "UPDATE `detalle_alimento` SET `alimento_codigo`=?,"
                . "`fecha_vencimiento`=?,"
                . "`contenido`=?,`peso_unitario`=?,"
                . "`stock`=?,`reservado`=? WHERE Id=?";
        $args = $detalle->getArray();

        array_pop($args);
        array_push($args, $args[0]);
        array_shift($args);
        $mapper = function($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False;
        return $ret;
    }

    public function remove($id) {
        $sql = "DELETE FROM detalle_alimento WHERE detalle_alimento.id = ?";
        $args = [$id];
        $mapper = function ($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False; // short if, mas comodo 
        // TODO: que devuelven los remove y los edit?
        return $ret;
    }

    public function getAll() {
        $sql = "SELECT * FROM detalle_alimento";
        $args = [];
        $mapper = function($row) {
            return new DetalleModel($row['Id'], $row['alimento_codigo'], $row['fecha_vencimiento'], $row['contenido'], $row['peso_unitario'], $row['stock'], $row['reservado'], $row['alimento_codigo']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    
    public function getAllVencimientoCercano() {
        $sql = "SELECT * FROM detalle_alimento";
        $args = [];
        $mapper = function($row) {
            return new DetalleModel($row['Id'], $row['alimento_codigo'], $row['fecha_vencimiento'], $row['contenido'], $row['peso_unitario'], $row['stock'], $row['reservado'], $row['alimento_codigo']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function getByID($id) {
        $sql = "SELECT * FROM detalle_alimento WHERE detalle_alimento.Id = ?";
        $args = [$id];
        $mapper = function($row) {
            return new DetalleModel($row['Id'], $row['alimento_codigo'], $row['fecha_vencimiento'], $row['contenido'], $row['peso_unitario'], $row['stock'], $row['reservado'], $row['alimento_codigo']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False; // short if, mas comodo
        return $ret;
    }

    public function exist($id) {
        
    }

}

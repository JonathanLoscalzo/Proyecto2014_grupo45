<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("PDOrepository.php");
include_once("model/EstadoPedidoModel.php");

class EstadoPedidoRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function getByID($id) {
        $sql = "SELECT * FROM estado_pedido WHERE Id=?";
        $args = [$id];
        $mapper = function ($row) {
            return new EstadoPedidoModel($row['id'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0]; // deberia devolver solo 1. 
    }
    public function add($obj) {
        $sql = "insert into estado_pedido values(?,?)";
        $args = $obj->getArray();
        $mapper = function($row){
            return $row;
        };
        
        return $this->queryList($sql, $args, $mapper);
    }

    public function edit($obj) {
        $sql = "update estado_pedido set descripcion = ? where id = ?";
        $args = $obj->getArray();
        array_push($args, $args[0]);
        array_shift($args);
        
        $mapper = function($row){ return $row ; };
        $answer = $this->queryList($sql, $args, $mapper);
        return count($answer) > 0 ? $answer[0] : False;
    }
    public function exist($id) {}

    public function getAll() {
        
        $sql = "SELECT * FROM estado_pedido";
        $args = [];
        $mapper = function ($row) {
            return new EstadoPedidoModel($row['id'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
        
    }

    public function remove($id) {
        $sql = "delete from estado_pedido where id = ?";
        $args = [$id];
        $mapper = function ($row) {
            return $row;
        };
        return $this->queryList($sql, $args, $mapper)[0];
    }
}
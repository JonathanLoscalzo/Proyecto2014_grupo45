<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TurnoRepository
 *
 * @author loscalzo
 */
class TurnoRepository extends PDORepository{
    private static $instance = null;
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    
    public function add($obj) {
        $sql = "insert into turno_entrega values(?,?,?)";
        $args = $obj->getArray();
        $mapper = function($row){
            return $row;
        };
        
        return $this->queryList($sql, $args, $mapper);
    }

    public function edit($obj) {
        $sql = "update turno_entrega set fecha = ?, hora = ? where id = ?";
        $args = $obj->getArray();
        array_push($args, $args[0]);
        array_shift($args);
        
        $mapper = function($row){ return $row ; };
        $answer = $this->queryList($sql, $args, $mapper);
        return count($answer) > 0 ? $answer[0] : False;
    }

    public function exist($id){}
    
    public function exists($fecha, $hora) {
        $sql = "SELECT * FROM turno_entrega where fecha = ? and hora = ?";
        $args = [$fecha, $hora];
        $mapper = function ($row) {
            return new TurnoModel($row['id'], $row['fecha'], $row['hora']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return ($answer) ? TRUE : FALSE;
    }

    public function getAll() {
        
        $sql = "SELECT * FROM turno_entrega";
        $args = [];
        $mapper = function ($row) {
            return new TurnoModel($row['id'],  date("d/m/Y", strtotime($row['fecha'])), $row['hora']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
        
    }

    public function getByID($id) {
        $sql = "SELECT * FROM turno_entrega where id = ?";
        $args = [$id];
        $mapper = function ($row) {
            return new TurnoModel($row['id'], date("d/m/Y", strtotime($row['fecha'])),$row['hora']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0];
    }

    public function remove($id) {
        $sql = "delete from turno_entrega where id = ?";
        $args = [$id];
        $mapper = function ($row) {
            return $row;
        };
        return $this->queryList($sql, $args, $mapper)[0];
    }
    public function getByFechaHora($fecha, $hora) {
        $sql = "SELECT * FROM turno_entrega where fecha = ? and hora = ?";
        $args = [$fecha, $hora];
        $mapper = function ($row) {
            return new TurnoModel($row['id'],  date("d/m/Y", strtotime($row['fecha'])), $row['hora']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0];
        
    }

//put your code here
}

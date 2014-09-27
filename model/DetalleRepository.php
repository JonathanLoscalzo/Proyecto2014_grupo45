<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("model/PDORepository.php");

class DetalleRepository extends PDORepository
{
    // TODO: no deberia pasarle un objeto como parametro el controlador en vez de
    // un array o un parametro suelto? No sería mas comodo y mas prolijo?
    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)){
            self::$instance = new static();
        }  
              
        return self::$instance;
    }
    public function add($detalle) {
        $sql = "INSERT INTO detalle_alimento VALUES(?, ?, ?, ?, ?, ?, ?)";
        $args = $detalle->getArray();
        $mapper = ""; 
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    public function get($id) {
        $sql = "SELECT * FROM detalle_alimento WHERE alimento.id = ?";
        $args = [$id];
        $mapper = function($row) {
            return new DetalleModel($row['id'], $row['alimento_codigo'], 
                    $row['fecha_vencimiento'], $row['contenido'], $row['peso_unitario'],
                    $row['stock'], $row['reservado']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) == 1 ? $answer[0] : false; // short if, mas comodo
        return $ret;
    }
    public function edit($alimento) {
        // por ahora no permito cambiarle el codigo, desp se verá si es necesario
        $sql = "UPDATE alimento SET descripcion=? WHERE alimento.codigo = ?";
        $args = $alimento->getArray();
        $mapper = function($row) {};
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) == 1 ? $answer[0] : false; // short if, mas comodo
        return $ret;
    }
    public function remove($codigo) {
        $sql = "DELETE FROM alimento WHERE alimento.codigo = ?";
        $args = ($codigo);
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) == 1 ? $answer[0] : false; // short if, mas comodo
        return $ret;
    }
    public function getAll() {
        $sql = "SELECT * FROM detalle_alimento";
        $args = [];
        $mapper = function($row) {
                $alimento = AlimentoRepository::getInstance()->getByID($row['alimento_codigo']);
                return new DetalleModel($row['id'], $row['alimento_codigo'], 
                    $row['fecha_vencimiento'], $row['contenido'], $row['peso_unitario'],
                    $row['stock'], $row['reservado'], new AlimentoModel($alimento['id'],
                            $alimento['descripcion']));
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) == 1 ? $answer[0] : false; // short if, mas comodo
        return $ret;
    }
    public function getByID($id) {
        $sql = "SELECT * FROM detalle_alimento WHERE detalle_alimento.id = ?";
        $args = [$id];
        $mapper = function($row) {
                $alimento = AlimentoRepository::getInstance()->getByID($row['alimento_codigo']);
                return new DetalleModel($row['id'], $row['alimento_codigo'], 
                    $row['fecha_vencimiento'], $row['contenido'], $row['peso_unitario'],
                    $row['stock'], $row['reservado'], new AlimentoModel($alimento['id'],
                            $alimento['descripcion']));
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) == 1 ? $answer[0] : false; // short if, mas comodo
        return $ret;
    }
}
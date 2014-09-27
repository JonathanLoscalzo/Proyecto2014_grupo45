<?php

include_once("model/PDOrepository.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EntidadReceptoraRepository
 *
 * @author jloscalzo
 */
class NecesidadEntidadRepository extends PDORepository{
    private static $instance = null;
    
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function add($necesidadEntidad) {
        $sql = "INSERT INTO necesidad_entidad(descripcion) VALUES(?)";
        $args = $necesidadEntidad->getArray()['descripcion'];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    
}

class EstadoEntidadRepository extends PDORepository{
    private static $instance = null;
    
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function add($estadoEntidad) {
        $sql = "INSERT INTO estado_entidad(descripcion) VALUES(?)";
        $args = $estadoEntidad->getArray()['descripcion'];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    
}

class EntidadReceptoraRepository extends PDORepository{
    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function add($entidadReceptora) {
        $sql = "INSERT INTO entidad_receptora VALUES(?,?,?,?,?,?)";
        $args = $entidadReceptora->getArray();
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    public function edit($entidadReceptora) {
        $sql = "UPDATE `entidad_receptora` 
                SET `Id`=?,`razon_social`=?,`telefono`=?,
                `domicilio`=?,`estado_entidad_Id`=?,`necesidad_entidad_Id`=?,
                `servicio_prestado_Id`=? 
                WHERE id=?";
        $args = $entidadReceptora->getArray();
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
        
    }
    public function remove($entidadReceptora) {
        $sql = "DELETE FROM entidad_receptora WHERE entidad_receptora.id = ?";
        $args = $entidadReceptora->getArray ['id'];
        $mapper = "";
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
    public function getAll() {
        $sql = "SELECT entidad_receptora.* FROM entidad_receptora ";
        $args = [];
        $mapper = function($row) {
            return call_user_func_array(array(new EntidadReceptoraModel, $row));
            // es importante que venga con el mismo orden
            //http://stackoverflow.com/questions/744145/passing-an-array-as-arguments-not-an-array-in-php
        }; // deberia crear un builder, feo esto.

        $answer = $this->queryList($sql, $args, $mapper);

        return $answer;
        
    }
}

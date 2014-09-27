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
        $args = "";
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

class ServicioEntidadRepository extends PDORepository{
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
            $estado = EstadoEntidadRepository::getByID($row['estado_entidad_Id']);
            $necesidad = EstadoEntidadRepository::getByID($row['necesidad_entidad_Id']);
            $servicio = EstadoEntidadRepository::getByID($row['servicio_entidad_Id']);
            return new EntidadReceptoraModel($row['id'],$row['razon_social'],$row['telefono'],$row['domicilio'],$estado,$necesidad,$servicio);
        }; // deberia crear un builder, feo esto.

        $answer = $this->queryList($sql, $args, $mapper);

        return $answer;
        
    }
    public static function getByID($id) {
        // getByID
    }
}  

<?php

include_once("repository/PDOrepository.php");
include_once("repository/EstadoEntidadRepository.php");
include_once("repository/NecesidadEntidadRepository.php");
include_once("repository/ServicioPrestadoRepository.php");
include_once("model/EntidadReceptoraModel.php");
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
class EntidadReceptoraRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function add($entidadReceptora) {
        $sql = "INSERT INTO entidad_receptora(razon_social, telefono, domicilio,"
                . " latitud, longitud,"
                . " estado_entidad_Id, "
                . "necesidad_entidad_Id, "
                . "servicio_prestado_Id) VALUES(?,?,?,?,?,?,?,?)";
        $args = $entidadReceptora->getArray();
        array_shift($args);
        array_pop($args);
        array_pop($args);
        array_pop($args);
        $mapper = function($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function edit($entidadReceptora) {

        $sql = "UPDATE entidad_receptora
                SET Id=?,razon_social=?,telefono=?,domicilio=?,latitud=?,longitud=?,estado_entidad_Id=?,necesidad_entidad_Id=?,servicio_prestado_Id=? 
                WHERE Id=?";
        $args = $entidadReceptora->getArray();
        array_pop($args);
        array_pop($args);
        array_pop($args);
        array_push($args, $args[0]);

        $mapper = function($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False;
        return $ret;
    }

    public function remove($id) {
        $sql = "DELETE FROM entidad_receptora WHERE entidad_receptora.id = ?";
        $args = [$id];
        $mapper = function ($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False;
        return $ret;
    }

    public function getAll() {
        $sql = "SELECT entidad_receptora.* FROM entidad_receptora ";
        $args = [];

        $mapper = function($row) {
            // creamos un objeto por cada model que va embebido dentro de EntidadReceptoraModel
            // esto significa que si traemos un EntidadReceptora TAMBIEN TRAEMOS sus models referenciados
            // ya que la relacion es 1 a 1 SUPUESTAMENTE es preferible manejar la informacion de a bloques
            // para las altas / bajas / modificaciones.
        return new EntidadReceptoraModel($row['Id'], $row['razon_social'], $row['telefono'], 
                $row['domicilio'], $row['latitud'], $row['longitud'], 
                $row['estado_entidad_Id'], $row['necesidad_entidad_Id'], 
                $row['servicio_prestado_Id']);
        }; // deberia crear un builder, feo esto.

        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function getByID($id) {
        $sql = "SELECT * FROM entidad_receptora WHERE Id=?";
        $args = [$id];
        $mapper = function ($row) {
            return new EntidadReceptoraModel($row['Id'], $row['razon_social'], $row['telefono'], $row['domicilio'], $row['estado_entidad_Id'], $row['necesidad_entidad_Id'], $row['servicio_prestado_Id']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        $ret = count($answer) > 0 ? $answer[0] : False;
        return $ret;
    }

    public function getByRazonSocial($razonSocial) {
        $sql = "SELECT entidad_receptora.* FROM entidad_receptora WHERE entidad_receptora.razon_social = ?";
        $args = [$razonSocial];
        $mapper = function($row) {
            return new EntidadReceptoraModel($row['Id'], $row['razon_social'], $row['telefono'], $row['domicilio'], $row['estado_entidad_Id'], $row['necesidad_entidad_Id'], $row['servicio_prestado_Id']);
        }; // deberia crear un builder, feo esto.

        $answer = $this->queryList($sql, $args, $mapper);
        if (count($answer) == 1) {
            return $answer[0];
        } else {
            return False;
        }
    }
    
    public function exist($id){
        
    }

}

<?php

include_once("model/PDOrepository.php");
include_once("model/EstadoEntidadRepository.php");
include_once("model/NecesidadEntidadRepository.php");
include_once("model/ServicioPrestadoRepository.php");
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
        $sql = "UPDATE entidad_receptora
                SET Id=?,razon_social=?,telefono=?,domicilio=?,estado_entidad_Id=?,necesidad_entidad_Id=?,servicio_prestado_Id=? 
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
            // creamos un objeto por cada model que va embebido dentro de EntidadReceptoraModel
            // esto significa que si traemos un EntidadReceptora TAMBIEN TRAEMOS sus models referenciados
            // ya que la relacion es 1 a 1 SUPUESTAMENTE es preferible manejar la informacion de a bloques
            // para las altas / bajas / modificaciones.
            $estado = EstadoEntidadRepository::getInstance()->getByID($row['estado_entidad_Id']);
            $necesidad = NecesidadEntidadRepository::getInstance()->getByID($row['necesidad_entidad_Id']);
            $servicio = ServicioEntidadRepository::getInstance()->getByID($row['servicio_prestado_Id']);
            return new EntidadReceptoraModel($row['Id'],$row['razon_social'],$row['necesidad_entidad_Id'], $row['estado_entidad_Id'] ,$row['telefono'], $row['servicio_prestado_Id'], $row['domicilio'],$estado,$necesidad,$servicio);
        }; // deberia crear un builder, feo esto.
        
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
        
    }
    public static function getByID($id) {
        // getByID
    }
}  

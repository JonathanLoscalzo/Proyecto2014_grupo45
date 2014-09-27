<?php

include_once("model/Model.php");
include_once("model/NecesidadEntidadModel.php");
include_once("model/EstadoEntidadModel.php");
include_once("model/ServicioEntidadModel.php");

class EntidadReceptoraModel extends Model {

    private $id;
    private $razonSocial;
    private $telefono;
    private $domicilio;
    private $estadoEntidadID;
    private $necesidadEntidadID;
    private $servicioPrestadoID;
    private $servicio;
    private $estado;
    private $necesidad;

    public function __construct($id, $razonSocial, $necesidadEntidadID, $estadoEntidadID, $telefono, $servicioPrestadoID, $domicilio, $model_estado, $model_necesidad, $model_servicio) {
        $this->id = $id;
        $this->razonSocial = $razonSocial;
        $this->telefono = $telefono;
        $this->domicilio = $domicilio;
        $this->estadoEntidadID = $estadoEntidadID;
        $this->necesidadEntidadID = $necesidadEntidadID;
        $this->servicioPrestadoID = $servicioPrestadoID;
        $this->estado = $model_estado;
        $this->necesidad = $model_necesidad;
        $this->servicio = $model_servicio;
        
        var_dump($this);die;
    }

    public function getId() {
        return $this->id;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getNecesidad() {
        return $this->necesidad;
    }

    public function getServicio() {
        return $this->servicio;
    }

    public function getAll() {
        
    }

    public function getRazonSocial() {
        return $this->razonSocial;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getDomicilio() {
        return $this->domicilio;
    }

    public function getEstadoEntidadID() {
        return $this->estadoEntidadID;
    }

    public function getNecesidadEntidadID() {
        return $this->necesidadEntidadID;
    }

    public function getServicioPrestadoID() {
        return $this->servicioPrestadoID;
    }

    public function setRazonSocial() {
        return $this->razonSocial;
    }

    public function setTelefono() {
        return $this->telefono;
    }

    public function setDomicilio() {
        return $this->domicilio;
    }

    public function setEstadoEntidadID() {
        return $this->estadoEntidadID;
    }

    public function setNecesidadEntidadID() {
        return $this->necesidadEntidadID;
    }

    public function setServicioPrestadoID() {
        return $this->servicioPrestadoID;
    }

}

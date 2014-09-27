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

    public function __construct($id, $razonSocial, $telefono, $domicilio, $estadoEntidadID, $necesidadEntidadID, $servicioPrestadoID ) {
        /*
         * Se podria agregar un getByID en cada uno en vez de crear una clase e insertarsela (inyeccion). 
         * No se cual es la mejor opción
         * 
         */
        $this->id = $id;
        $this->razonSocial = $razonSocial;
        $this->telefono = $telefono;
        $this->domicilio = $domicilio;
        $this->estadoEntidadID = $estadoEntidadID;
        $this->necesidadEntidadID = $necesidadEntidadID;
        $this->servicioPrestadoID = $servicioPrestadoID;
        $this->estado = EstadoEntidadRepository::getInstance()->getByID($estadoEntidadID);
        $this->necesidad = NecesidadEntidadRepository::getInstance()->getByID($necesidadEntidadID);
        $this->servicio = ServicioEntidadRepository::getInstance()->getByID($servicioPrestadoID);
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

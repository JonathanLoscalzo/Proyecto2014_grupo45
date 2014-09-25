<?php
include_once("model/Model.php");

class EntidadReceptoraModel extends Model{

	private $id;
    private $razonSocial;
    private $telefono;
	private $domicilio;
	private $estadoEntidadID;
	private $necesidadEntidadID;
	private $servicioPrestadoID;

    
	public function __construct($id, $razonSocial, $necesidadEntidadID, $estadoEntidadID, $telefono, $servicioPrestadoID, $domicilio) {
        $this->id = $id;
        $this->razonSocial = $razonSocial;
        $this->telefono = $telefono;
        $this->domicilio = $domicilio;
        $this->estadoEntidadID = $estadoEntidadID;
        $this->necesidadEntidadID = $necesidadEntidadID;
        $this->servicioPrestadoID = $servicioPrestadoID;
    }

    public function getId() {
        return $this->id;
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
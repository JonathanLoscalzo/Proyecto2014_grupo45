<?php
include_once("model/Model.php");

class NecesidadEntidadModel extends model {
    // decidi meterla en el mismo archivo, debido a que el modelo es basicamente el mismo
    // estas clases dependen de la principal y la relacion es 1 a 1
    private $id;
    private $descripcion;
    public function __construct($id, $descripcion) {
        $this-> id = $id;
        $this-> descripcion = $descripcion;
    }
    public function getId() {
        return $this->id;
    }
    protected function setId($id) {
        // only for exclusive usage.
        $this->id = $id;
    }
    public function getDescripcion() {
        
        return $this->descripcion;
    }
    public function setDescripcion($descripcion) {
        $this -> descripcion = $descripcion;
    }
    
}

class EstadoEntidadModel extends Model {
    private $id;
    private $descripcion;
    public function __construct($id, $descripcion) {
        $this-> id = $id;
        $this-> descripcion = $descripcion;
    }
}

class EntidadReceptoraModel extends Model{

	private $id;
    private $razonSocial;
    private $telefono;
        private $estado;
        private $necesidad;
	private $domicilio;
	private $estadoEntidadID;
	private $necesidadEntidadID;
	private $servicioPrestadoID;

    
	public function __construct($id, $razonSocial, $necesidadEntidadID, 
                $estadoEntidadID, $telefono, $servicioPrestadoID, $domicilio, 
                $id_estado, $descripcion_estado, $id_necesidad, 
                $descripcion_necesidad) {
            $this->id = $id;
            $this->razonSocial = $razonSocial;
            $this->telefono = $telefono;
            $this->domicilio = $domicilio;
            $this->estadoEntidadID = $estadoEntidadID;
            $this->necesidadEntidadID = $necesidadEntidadID;
            $this->servicioPrestadoID = $servicioPrestadoID;
            $this->estado = new EstadoEntidadModel($id_estado, $descripcion_estado);
            $this->necesidad = new NecesidadEntidadModel($id_necesidad, $descripcion_necesidad);
    }

    public function getId() {
        return $this->id;
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
    public function getEstadoEntidad() {
        return $this->estado;
    }
    public function getNecesidadEntidad() {
        return $this->necesidad;
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
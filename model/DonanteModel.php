<?php

class DonanteModel extends Model {
    /* se podria crear un DonanteBuilder por cada atributo */

    private $razonSocial;
    private $apellido;
    private $nombre;
    private $telefono;
    private $email;
    private $domicilio;
    private $id;

    public function __construct($id, $razonSocial, $apellido, $nombre, $telefono, $email, $domicilio) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->domicilio = $domicilio;
        $this->telefono = $telefono;
        $this->razonSocial = $razonSocial;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDomicilio() {
        return $this->domicilio;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getRazonSocial() {
        return $this->razonSocial;
    }

    public function setNombre($attr) {
        $this->nombre = $attr;
    }

    public function setApellido($attr) {
        $this->apellido = $attr;
    }

    public function setEmail($attr) {
        $this->email = $attr;
    }

    public function setDomicilio($attr) {
        $this->domicilio = $attr;
    }

    public function setTelefono($attr) {
        $this->telefono = $attr;
    }

    public function setRazonSocial($attr) {
        $this->razonSocial = $attr;
    }
    
    

}

<?php

class TurnoModel extends Model {

    //put your code here

    public $id;
    public $fecha;
    public $hora;

    public function __construct($id, $fecha, $hora) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora = $hora;
    }

    public function getId() {
        return $this->id;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setFecha($fecha) {
        return $this->fecha = $fecha;
    }

    public function setHora($hora) {
        return $this->hora= $hora;
    }

}

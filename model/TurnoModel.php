<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TurnoModel
 *
 * @author loscalzo
 */
class TurnoModel extends Model {

    //put your code here

    protected $id;
    protected $fecha;
    protected $hora;

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
        return $this->Hora;
    }

    public function setFecha($fecha) {
        return $this->fecha = $fecha;
    }

    public function setHora($hora) {
        return $this->hora= $hora;
    }

}

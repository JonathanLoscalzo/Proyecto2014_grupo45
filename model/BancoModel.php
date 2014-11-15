<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("Model.php");

class BancoModel extends Model {
    public $id;
    public $nombre;
    public $ubicacion;
    public $lat;
    public $long;
    
    
    
    public function __construct($id, $nombre, $ubicacion, $lat, $long) {
        $this->nombre = $nombre;
        $this->ubicacion = $ubicacion;
        $this->lat = $lat;
        $this->long = $long;
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getNombre () {
        return $this->nombre;
    }
    public function getUbicacion() {
        return $this->ubicacion;
    }
    public function getLat() {
        return $this->lat;
    }
    public function getLong() {
        return $this->long;
    }
    
}    
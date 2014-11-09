<?php
include_once("model/Model.php");

class EstadoEntidadModel extends Model {

    public $id;
    public $descripcion;

    public function __construct($id, $descripcion) {
        $this->id = $id;
        $this->descripcion = $descripcion;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        // only for exclusive usage.
        $this->id = $id;
    }

    public function getDescripcion() {

        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

}
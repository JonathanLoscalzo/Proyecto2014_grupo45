<?php
include_once("model/Model.php");
class ServicioEntidadModel extends Model {

    
    private $id;
    private $descripcion;

    public function __construct($id, $descripcion) {
        $this->id = $id;
        $this->descripcion = $descripcion;
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
        $this->descripcion = $descripcion;
    }


}
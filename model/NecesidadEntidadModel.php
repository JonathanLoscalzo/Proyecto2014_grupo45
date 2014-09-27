<?php

class NecesidadEntidadModel extends model {

    // decidi meterla en el mismo archivo, debido a que el modelo es basicamente el mismo
    // estas clases dependen de la principal y la relacion es 1 a 1
    // hice las variables publicas para denotar el tema de que en la VISTA se esta
    // referenciando al objeto como si fuese publico, instancia.VARIABLE, cuando se 
    // deberia usar getters.
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

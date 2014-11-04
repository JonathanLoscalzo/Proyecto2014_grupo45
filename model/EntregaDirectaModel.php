<?php

class EntregaDirectaModel extends Model{
    protected $id;
    protected $entidad; // puede ser el id o el objeto
    protected $fecha; 
    protected $alimentos; // deberia ser un array. 
    
    public function __construct($id, $entidad, $fecha) {
        $this->id = $id;
        $this->entidad = $entidad;
        $this->fecha = $fecha;
        //busco todos los alimentos de esta entrega (arreglo de objetos)
        //$this->alimentos = AlimentoEntregaDirectaRepository::getInstance()->getAllById($id);
        return $this;
    }
    
    public function getId(){
        return $this->id ;
    }
    public function getEntidad(){
        return $this->entidad;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getAlimentos(){
        return $this->alimentos;
    }
    
    public  function cambiar(){
        /* Cuando quiero usarlo como objetos*/
        $this->entidad = EntidadReceptoraRepository::getInstance()->getByID($this->entidad);
        $this->alimentos = AlimentoEntregaDirectaRepository::getInstance()->getAllById($this->id);
    }
    
    
}

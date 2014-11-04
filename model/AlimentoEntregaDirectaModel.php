<?php

class AlimentoEntregaDirectaModel extends Model {

    protected $entregaDirecta;
    protected $detalle_alimento;
    protected $cantidad;

    public function __construct($entregaDirecta, $detalle_alimento, $cantidad) {
        $this->entregaDirecta = $entregaDirecta;
        $this->detalle_alimento = $detalle_alimento;
        $this->cantidad = $cantidad;
        return $this;
    }
    public function getEntregaDirecta(){
        return $this->entregaDirecta;
    }
    public function getDetalle_alimento(){
        return $this->detalle_alimento;
    }
    public function getCantidad(){
        return $this->cantidad;
    }
    
    public function cambiar(){
        /* Cuando quiero que las variables sean mis objetos */
        $this->entregaDirecta = EntregaDirectaRepository::getInstance()->getByID($this->entregaDirecta);
        $this->detalle_alimento = DetalleRepository::getInstance()->getByID($this->detalle_alimento);
    }
    
    

}

<?php

include_once("repository/DetalleRepository.php");

class PedidoHasDetallesModel extends Model
{
	public $numero;
        public $detalle_alimento_id;
        public $cantidad;
        public $detalle_alimento_model;

	public function __construct($numero, $detalle_alimento_id, $cantidad){
            $this->numero = $numero;
            $this->detalle_alimento_id = $detalle_alimento_id;
            $this->cantidad = $cantidad;
            $this->detalle_alimento_model = DetalleRepository::getInstance()->getByID($detalle_alimento_id);
            return $this;
            
        }
        
        public function getNumero() {
            return $this->numero;
            
        }
        
        public function getDetalle_alimento_id(){
            return $this->detalle_alimento_id;
        }
        public function getcantidad () {
            return $this->cantidad;
        }
        public function getDetalle_alimento_model() {
            return $this->detalle_alimento_model;
        }
        
}

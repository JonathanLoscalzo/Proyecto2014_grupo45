<?php

include_once("repository/DetalleRepository.php");

class PedidoHasDetallesModel extends Model
{
	protected $numero;
        protected $detalle_alimento_id;
        protected $cantidad;
        protected $detalle_alimento_model;

	public function __construct($numero, $detalle_alimento_id, $cantidad){
            $this->numero = $numero;
            $this->detalle_alimento_id = $detalle_alimento_id;
            $this->cantidad = $cantidad;
            $this->detalle_alimento_model = DetalleRepository::getInstance()->getByID($detalle_alimento_id);
            return $this;
            
        }
}

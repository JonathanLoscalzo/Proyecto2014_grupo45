<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("Model.php");
include_once("repository/EstadoPedidoRepository.php");
include_once("repository/TurnoRepository.php");
include_once("repository/PedidoHasDetallesRepository.php");
include_once("repository/EntidadReceptoraRepository.php");

class PedidoModel extends Model
{
	public $numero;
        public $entidad_receptora_id;
	public $fecha_ingreso;
        public $estado_pedido_id;
        public $turno_entrega_id;
        public $con_envio;
        public $entidad_receptora_model;
        public $estado_pedido_model;
        public $turno_entrega_model;
        public $alimento_pedido_array;

	public function __construct($numero, $entidad_receptora_id, $fecha_ingreso, 
                $estado_pedido_id, $turno_entrega_id, $con_envio){
            $this->numero = $numero;
            $this->entidad_receptora_id = $entidad_receptora_id;
            $this->estado_pedido_id = $estado_pedido_id;
            $this->turno_entrega_id = $turno_entrega_id;
            $this->entidad_receptora_model = EntidadReceptoraRepository::
                    getInstance()->getByID($entidad_receptora_id);
            $this->fecha_ingreso = $fecha_ingreso;
            $this->estado_pedido_model = EstadoPedidoRepository::
                    getInstance()->getByID($estado_pedido_id);// QUERY HERE
            $this->turno_entrega_model = TurnoRepository::
                    getInstance()->getByID($turno_entrega_id);// QUERY HERE
            $this->con_envio = $con_envio;
            $this->alimento_pedido_array = PedidoHasDetallesRepository::getInstance()->
                    getByPedido($numero); // devuelve un array de PedidoHasDetallesModel
            return $this;
	}
        
        public function setNumero($numero) {
            $this->numero = $numero;
        }
        public function getNumero() {
            return $this->numero;
        }
        public function getEntidad_receptora_id() {
            return $this->entidad_receptora_id;
        }
        public function getTurno_entrega_id() {
            return $this->turno_entrega_id;
        }
        public function getAlimento_pedido_array() {
            return $this->alimento_pedido_array;
        }
        
        public function getEstadoPedido(){
            return $this->estado_pedido_model;
        }
        
}



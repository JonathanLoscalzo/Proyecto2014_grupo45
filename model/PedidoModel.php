<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PedidoModel extends Model
{
	protected $numero;
        protected $entidad_receptora_id;
	protected $fecha_ingreso;
        protected $estado_pedido_id;
        protected $turno_entrega_id;
        protected $con_envio;
        protected $entidad_receptora_model;
        protected $estado_pedido_model;
        protected $turno_entrega_model;
        protected $alimento_pedido_array;

	public function __construct($numero, $entidad_receptora_id, $fecha_ingreso, 
                $estado_pedido_id, $turno_entrega_id, $con_envio){
            $this->numero = $numero;
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
        
        
}



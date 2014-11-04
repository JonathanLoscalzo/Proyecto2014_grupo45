<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EstadoPedidoModel extends Model
{
	protected $id;
        protected $descripcion;

	public function __construct($id, $descripcion){
            $this->id = $id;
            $this->descripcion = $descripcion;
            return $this;
        }
}

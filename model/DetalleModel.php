<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DetalleModel extends Model
{
	protected $id;
	protected $alimento_codigo;
        protected $fecha_vencimiento;
        protected $contenido;
        protected $peso_unitario;
        protected $stock;
        protected $reservado;
        protected $alimento_model;
        
	public function __construct($id, $alimento_codigo, $fecha_vencimiento,
                $contenido, $peso_unitario, $stock, $reservado){
            $this->alimento_codigo = $alimento_codigo;
            $this->contenido = $contenido;
            $this->fecha_vencimiento = $fecha_vencimiento;
            $this->id = $id;
            $this->peso_unitario = $peso_unitario;
            $this->reservado = $reservado;
            $this->stock = $stock;
            $this->alimento_model = AlimentoRepository::getInstance()->getByID($alimento_codigo);
            // var alimento model corresponde a un tipo de alimento (AlimentoModel)
            return $this;
	}

	public function getAlimentoCodigo(){
		return $this->alimento_codigo;
	}

	public function getId(){
		return $this->id;
	}

	protected function setAlimentoCodigo($codigo){
		return $this->alimento_codigo = $codigo;
	}

	public function setId($id){
		return $this->id = $id;
	}
        public function getContenido() {
            return $this->contenido;
        }
        public function getFechaVencimiento() {
            return $this->fecha_vencimiento;
        }
        public function getPesoUnitario() {
            return $this->peso_unitario;
        }
        public function getStock() {
            return $this->stock;
        }
        public function getReservado() {
            return $this->reservado;
        }
        public function getAlimento () {
            return $this->alimento_model;
        }
}
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DetalleModel extends Model
{
	public $id;
	public $alimento_codigo;
        public $fecha_vencimiento;
        public $contenido;
        public $peso_unitario;
        public $stock;
        public $reservado;
        public $alimento_model;
        
	public function __construct($id, $alimento_codigo, $fecha_vencimiento,
                $contenido, $peso_unitario, $stock, $reservado){
            $this->alimento_codigo = $alimento_codigo;
            $this->contenido = $contenido;
            $this->fecha_vencimiento = $fecha_vencimiento;
            $this->id = $id;
            $this->peso_unitario = $peso_unitario;
            $this->reservado = $reservado;
            $this->stock = $stock;
            $this->alimento_model = AlimentoRepository::getInstance()->get($alimento_codigo);
            // var alimento model corresponde a un tipo de alimento (AlimentoModel)
            return $this;
	}

	public function getAlimento_Codigo(){
		return $this->alimento_codigo;
	}

	public function getId(){
		return $this->id;
	}

	public function setAlimentoCodigo($codigo){
		return $this->alimento_codigo = $codigo;
	}

	public function setId($id){
		return $this->id = $id;
	}
        public function getContenido() {
            return $this->contenido;
        }
        public function getFecha_Vencimiento() {
            return $this->fecha_vencimiento;
        }
        public function getPeso_Unitario() {
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
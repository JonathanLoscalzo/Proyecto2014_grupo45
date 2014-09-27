<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DetalleModel extends Model
{
	private $id;
	private $alimento_codigo;
        private $fecha_vencimiento;
        private $contenido;
        private $peso_unitario;
        private $stock;
        private $reservado;
        private $alimento_model;
        
	public function __construct($id, $alimento_codigo, $fecha_vencimiento,
                $contenido, $peso_unitario, $stock, $reservado, $alimento_model){
            $this->alimento_codigo = $alimento_codigo;
            $this->contenido = $contenido;
            $this->fecha_vencimiento = $fecha_vencimiento;
            $this->id = $id;
            $this->peso_unitario = $peso_unitario;
            $this->reservado = $reservado;
            $this->stock = $stock;
            $this->alimento_model = $alimento_model;
            // var alimento model corresponde a un tipo de alimento (AlimentoModel)
	}

	public function getAlimentoCodigo(){
		return $this->alimento_codigo;
	}

	public function getId(){
		return $this->id;
	}

	private function setAlimentoCodigo($codigo){
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
}
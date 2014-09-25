<?php

class AlimentoModel extends Model
{
	private $codigo; 
	private $descripcion;

	public function __construct(){

	}

	public function getCodigo(){
		return $this->codigo;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	private function setCodigo($codigo){
		return $this->codigo = $codigo;
	}

	public function setDescripcion($descripcion){
		return $this->descripcion = $descripcion;
	}
}
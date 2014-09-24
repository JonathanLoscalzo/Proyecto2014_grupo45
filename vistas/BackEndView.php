<?php

include_once('vistas/TwigView.php');

class BackEndView extends TwigView {
	public function index(){
		echo self::getTwig()->render('index-backend.php');
	}
	public function listado_alimentos(){
		
		echo self::getTwig()->render('ListadoAlimentos.php');
	}
	public function entidadesReceptoras(){
		echo self::getTwig()->render('EntidadesReceptoras.php');
	}
	public function donantes(){
		echo self::getTwig()->render('Donantes.php');
	}
	public function alimentos(){
		echo self::getTwig()->render('Alimentos.php');
	}
}
<?php

include_once('vistas/TwigView.php');

class BackEndView extends TwigView {
	public function index(){
		echo self::getTwig()->render('index-backend.php');
	}
	public function listado_alimentos(){
		echo self::getTwig()->render('listado_alimentos.php');
	}
	public function entidadesReceptoras(){
		echo self::getTwig()->render('ABMentidadesReceptoras.php');
	}
	public function donantes(){
		echo self::getTwig()->render('ABMDonantes.php');
	}
	public function alimentos(){
		echo self::getTwig()->render('ABMalimentos.php');
	}
}
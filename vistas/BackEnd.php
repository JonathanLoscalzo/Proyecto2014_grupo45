<?php
require_once('vistas/TwigView.php')
class backend extends TwigView {
	public function index(){
		echo self::getTwig()->render('backend/index.php');
	}
	public function listado_alimentos(){
		echo self::getTwig()->render('backend/listado_alimentos.php');
	}
	public function entidadesReceptoras(){
		echo self::getTwig()->render('backend/ABMentidadesReceptoras.php');
	}
	public function donantes(){
		echo self::getTwig()->render('backend/ABMDonantes.php');
	}
	public function alimentos(){
		echo self::getTwig()->render('backend/ABMalimentos.php');
	}
}
<?php
/*esto es la logica de la vista*/
require_once('vistas/TwigView.php');

class FrontEndView extends TwigView {
	public function index(){
		echo self::getTwig()->render('index.php');
	}
	public function login(){
		echo self::getTwig()->render('login.php');
	}
	public function proyectos(){
		echo self::getTwig()->render('Proyectos.php');
	}
	public function voluntariado(){
		echo self::getTwig()->render('Voluntariado.php');
	}
	public function dona_ahora(){
		echo self::getTwig()->render('Dona-ahora.php');
	}
}
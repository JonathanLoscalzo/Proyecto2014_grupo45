<?php
/*esto es la logica de la vista*/
require_once('vistas/TwigView.php')
class FrontEnd extends TwigView {
	public function index(){
		echo self::getTwig()->render('frontend/index.php');
	}
	public function login(){
		echo self::getTwig()->render('frontend/login.php');
	}
	public function proyectos(){
		echo self::getTwig()->render('frontend/Proyectos.php');
	}
	public function voluntariado(){
		echo self::getTwig()->render('frontend/Voluntariado.php');
	}
	public function dona_ahora(){
		echo self::getTwig()->render('frontend/Dona-ahora.php');
	}
}
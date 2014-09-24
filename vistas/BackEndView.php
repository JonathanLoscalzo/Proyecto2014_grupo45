<?php

include_once('vistas/TwigView.php');

class BackEndView extends TwigView {
	public function index($message=""){
		$twig = self::getTwig();
		//session_start();
        $twig->addGlobal('session', $_SESSION); // nose si està bien esto
		echo self::getTwig()->render('index-backend.php', array('message' => $message));
	}
	public function listado_alimentos(){
		
		echo self::getTwig()->render('ListadoAlimentos.php');
	}
	public function entidadesReceptoras(){
		echo self::getTwig()->render('EntidadesReceptoras.php');
	}
	public function donantes($donantes){
		

		echo self::getTwig()->render('Donantes.php', array('donantes', $donantes));
	}
	public function alimentos(){
		echo self::getTwig()->render('Alimentos.php');
	}
}
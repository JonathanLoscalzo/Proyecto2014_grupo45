<?php
/*
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);*/
/* Esto es el manejador de la URL, o Front-controller, o nose como se llama */

require_once('controller/HomeController.php');
require_once('vistas/TwigView.php');
require_once('vistas/BackEnd.php');
require_once('vistas/FrontEnd.php');


var_dump($_SERVER['REQUEST_URI']);
switch ($_SERVER['REQUEST_URI']) {
	case '/index':
		HomeController::getInstance()->index();
		break;
	case '/login':
		HomeController::getInstance()->login();
		break;
	case '/Proyectos':
		HomeController::getInstance()->proyectos();
		break;
	case '/Voluntariado':
		HomeController::getInstance()->voluntariado();
		break;
	case '/Dona-ahora':
		HomeController::getInstance()->dona_ahora();
		break;
	default:
		HomeController::getInstance()->index();
		break;
		// Deberìa redireccionarte a una pagina 404 o algo asi	
}



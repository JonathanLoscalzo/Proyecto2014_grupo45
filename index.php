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


/*ver como hacer para poder leer la uri en partes 
	ROUTE 
	/page/action/id
	Tendriamos que respetar ese formato. 
	cuando se hace local, TENER EN CUENTA que XAMPP agrega /BANCOALIMENTARIO
	pero en el servidor no es necesario agregar esa parte.

	CUANDO ESTOY EN EL SERVIDOR LOCAL, TENDRIA QUE PONER DESDE 2 EN ADELANTE.
	CUANDO ESTOY EN PRODUCCION, O EN EL GITLAB, HABRÌA QUE PONER UNO MENOS.

*/

if (!isset($GLOBALS["url_base"])){
	$GLOBALS["url_base"] = "localhost/BancoAlimentario/index.php";
}

$acciones = split("/",$_SERVER['REQUEST_URI']);

switch ($acciones[1]) {
	case "index":
		HomeController::getInstance()->index();
		break;
	case "login":
		HomeController::getInstance()->login();
		break;
	case "Proyectos":
		HomeController::getInstance()->proyectos();
		break;
	case "Voluntariado":
		HomeController::getInstance()->voluntariado();
		break;
	case "Dona-ahora":
		HomeController::getInstance()->dona_ahora();
		break;
	default:
		HomeController::getInstance()->index();
		break;
		// Deberìa redireccionarte a una pagina 404 o algo asi	
}



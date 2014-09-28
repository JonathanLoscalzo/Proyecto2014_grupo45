<?php

/*
  ini_set('display_startup_errors',1);
  ini_set('display_errors',1);
  error_reporting(-1); */
/* Esto es el manejador de la URL, o Front-controller, o nose como se llama */

require_once('controller/HomeController.php');
require_once('controller/LoginController.php');
require_once('controller/AlimentoController.php');
require_once('controller/EntidadReceptoraController.php');
require_once('controller/DonanteController.php');
require_once('controller/AlimentoController.php');
require_once('vistas/TwigView.php');
require_once('vistas/BackEndView.php');
require_once('vistas/FrontEndView.php');
require_once("model/ParamsClass.php");



/* ver como hacer para poder leer la uri en partes 
  ROUTE
  /page/action/id
  Tendriamos que respetar ese formato.
  cuando se hace local, TENER EN CUENTA que XAMPP agrega /BANCOALIMENTARIO
  pero en el servidor no es necesario agregar esa parte.

  CUANDO ESTOY EN EL SERVIDOR LOCAL, TENDRIA QUE PONER DESDE 2 EN ADELANTE.
  CUANDO ESTOY EN PRODUCCION, O EN EL GITLAB, HABRÌA QUE PONER UNO MENOS.

 */


$acciones = split("/", $_SERVER['REQUEST_URI']);

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
    case "login-user":
        $username = (isset($_POST["username"])) ? $_POST["username"] : "";
        $pass = (isset($_POST["pass"])) ? $_POST["pass"] : "";
        LoginController::getInstance()->login($username, $pass);
        break;
    case 'logout':
        LoginController::getInstance()->logout();
        break;
    case 'backend':
        LoginController::getInstance()->backend();
        break;
    case 'donantes':
        
        (!isset($acciones[2]) ? $acciones[2] = "" : ""); //feo
        switch ($acciones[2]) {
        case "edit":
            if (!isset($_POST['submit'])) {
                /* deberia ser como la pantalla de crear */
                DonanteController::getInstance()->editView($acciones[3]);
            } else {
                $donante = new Params($_POST);
                DonanteController::getInstance()->edit($donante);
            }
            break;
        case "remove":
            DonanteController::getInstance()->remove($acciones[3]);
            break;
        case "add":
            /* agarrar todas las variables del post y mandarlas */
            $donante = new Params($_POST);

            DonanteController::getInstance()->create($donante);
            break;
        default:
            DonanteController::getInstance()->index();
            break;
        }
        break;
    case 'entidadesReceptoras':
        (!isset($acciones[2]) ? $acciones[2] = "" : ""); //feo
        switch ($acciones[2]) {
        case "edit":
                if (!isset($_POST['submit'])) {
                    /* deberia ser como la pantalla de crear */
                    EntidadReceptoraController::getInstance()->editView($acciones[3]);
                } else {
                    EntidadReceptoraController::getInstance()->edit(new Params($_POST));
                }
                break;
            case "remove":
                EntidadReceptoraController::getInstance()->remove($acciones[3]);
                break;
            case "add":
                /* agarrar todas las variables del post y mandarlas */
                EntidadReceptoraController::getInstance()->create(new Params($_POST));
                break;
            default:
                EntidadReceptoraController::getInstance()->index();
                break;
        }
        break;
    case 'alimentos':
        (!isset($acciones[2]) ? $acciones[2] = "" : ""); //feo
        
        switch ($acciones[2]) {
        case "edit":
            if (!isset($_POST['submit'])) {
                /* deberia ser como la pantalla de crear */
                AlimentoController::getInstance()->editView($acciones[3]);
            } else {
                AlimentoController::getInstance()->edit(new Params($_POST));
            }
            break;
        case "remove":
            AlimentoController::getInstance()->remove($acciones[3]);
            break;
        case "add":
            /* agarrar todas las variables del post y mandarlas */
            AlimentoController::getInstance()->create(new Params($_POST));
            break;
        default:
            AlimentoController::getInstance()->index();
            break;
        }
        break;
    case 'listadoAlimentos':
        if (LoginController::isSessionStart()){
            AlimentoController::getInstance()->listarAlimentos();
        }
        else{
            $view = new FrontEndView();
            $view-> index(LoginStatus::call(3));
        }
        break;
    default:
        HomeController::getInstance()->index(); 
        break;
    // Deberìa redireccionarte a una pagina 404 o algo asi	
}



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
require_once('controller/EnviosController.php');
require_once('vistas/TwigView.php');
require_once('vistas/BackEndView.php');
require_once('vistas/FrontEndView.php');
require_once("model/ParamsClass.php");
require_once("model/UserModel.php");
require_once 'repository/UserRepository.php';
require_once 'controller/UsuarioController.php';
require_once 'repository/RoleRepository.php';
require_once 'model/RoleModel.php';
require_once 'controller/TurnoController.php';
require_once 'repository/TurnoRepository.php';
require_once 'model/TurnoModel.php';
require_once 'controller/EntregaDirectaController.php';
require_once 'model/EntregaDirectaModel.php';
require_once 'repository/EntregaDirectaRepository.php';
require_once 'model/AlimentoEntregaDirectaModel.php';
require_once 'repository/AlimentoEntregaDirectaRepository.php';

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

if (isset($_POST['date'])) {
    EnviosController::getInstance()->editView(new Params($_POST));
} else {

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
        case "lista_donantes":
            HomeController::getInstance()->listDonante();
            break;
        case 'lista_entidadesreceptoras':
            HomeController::getInstance()->listadoEntidadesReceptoras();
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
        case 'envios':
            EnviosController::getInstance()->index();
            break;
        case 'donantes':
            (!isset($acciones[2]) ? $acciones[2] = "" : ""); //feo
            switch ($acciones[2]) {
                case "edit":
                    if (!isset($_POST['submit'])) {
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
        case 'usuarios':
            (!isset($acciones[2]) ? $acciones[2] = "" : ""); //feo

            switch ($acciones[2]) {
                case "edit":
                    if (!isset($_POST['submit'])) {
                        /* deberia ser como la pantalla de crear */
                        UsuarioController::getInstance()->editView($acciones[3]);
                    } else {
                        UsuarioController::getInstance()->edit(new Params($_POST));
                    }
                    break;
                case "remove":
                    UsuarioController::getInstance()->remove($acciones[3]);
                    break;
                case "add":
                    /* agarrar todas las variables del post y mandarlas */
                    UsuarioController::getInstance()->create(new Params($_POST));
                    break;
                default:
                    UsuarioController::getInstance()->index();
                    break;
            }
            break;
        case 'turnosEntrega':
            (!isset($acciones[2]) ? $acciones[2] = "" : ""); //feo

            switch ($acciones[2]) {
                case "edit":
                    if (!isset($_POST['submit'])) {
                        /* deberia ser como la pantalla de crear */
                        TurnoController::getInstance()->editView($acciones[3]);
                    } else {
                        TurnoController::getInstance()->edit(new Params($_POST));
                    }
                    break;
                case "remove":
                    TurnoController::getInstance()->remove($acciones[3]);
                    break;
                case "add":
                    /* agarrar todas las variables del post y mandarlas */
                    TurnoController::getInstance()->create(new Params($_POST));
                    break;
                default:
                    TurnoController::getInstance()->index();
                    break;
            }
            break;
        case 'EntregaDirecta':
            (!isset($acciones[2]) ? $acciones[2] = "" : ""); //feo
            switch ($acciones[2]) {
                case "edit":
                    if (!isset($_POST['submit'])) {
                        /* deberia ser como la pantalla de crear */
                        EntregaDirectaController::getInstance()->editView($acciones[3]);
                    } else {
                        EntregaDirectaController::getInstance()->edit(new Params($_POST));
                    }
                    break;
                case "remove":
                    EntregaDirectaController::getInstance()->remove($acciones[3]);
                    break;
                case "add":
                    /* agarrar todas las variables del post y mandarlas */
                    print_r($_REQUEST["datos"]);
                    //EntregaDirectaController::getInstance()->create(new Params($_POST));
                    break;
                default:
                    EntregaDirectaController::getInstance()->index();
                    break;
            }
            break;
        case 'listadoAlimentos':
            if (LoginController::isSessionStart()) {
                AlimentoController::getInstance()->listarAlimentos();
            }
            break;
        default:
            HomeController::getInstance()->index();
            break;
        // Deberìa redireccionarte a una pagina 404 o algo asi	
    }
}

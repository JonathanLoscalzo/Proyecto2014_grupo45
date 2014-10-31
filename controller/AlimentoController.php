<?php

include_once('Controller.php');
include_once("model/PDOrepository.php");
include_once("controller/RoleService.php");
include_once("model/AlimentoRepository.php");
include_once("model/AlimentoModel.php");
include_once("model/DetalleRepository.php");
include_once("model/DetalleModel.php");

class AlimentoController extends Controller {

    private static $instance = null;

    protected function redirect() {
        parent::redirect("alimentos");
    }
    
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function create($post) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $data = $post->getParams(); // obtenemos Los parametros
// se crea con NULL debido a que ID es auto-incremental
                $data['fecha_vencimiento'] = date("Y-m-d", strtotime($data['fecha_vencimiento']));
// convert to yyyy-mm-dd format
                if ($data['flag'] == 1) {
// VOY A USAR INTEGER EN VEZ DE BOOL, 1 = TRUE, 0 = FALSE
// SI SE DESEA CREAR TAMBIEN UN ALIMNETO NUEVO
                    $query_alimento = AlimentoRepository::getInstance()->get($data['codigo-nuevo']);
                    
                    if (!$query_alimento) {
// Si no hay alimento con el mismo codigo...
                        $alimento = new AlimentoModel($data['codigo-nuevo'], $data['descripcion-nueva']);
                        AlimentoRepository::getInstance()->add($alimento); // es necesario que se haga en este instante para que funcione el
// constructor de abajo
                        $detalle_entidad = new DetalleModel(null, $alimento->getCodigo(), $data['fecha_vencimiento'], $data['contenido'], $data['peso_unitario'], $data['stock'], $data['reservado']); // creamos el nuevo objeto que se introducira en la BD
                        DetalleRepository::getInstance()->add($detalle_entidad);
                        $_SESSION["message"] = new MessageService("createSuccess", ["paquete y tipo ".$data['codigo-nuevo']]);
                    } else { 
                        $_SESSION["message"] = new MessageService("createErrorExist", ["alimento de tipo ".$data['codigo-nuevo']]);
                    }
                } else {
// SI UNICAMENTE SE DESEA CREAR UN DETALLE, CON SU ALIMENTO ASOCIADO 
// EXISTENTE EN LA BD:
                    $detalle_entidad = new DetalleModel(null, $data['alimento_codigo'], $data['fecha_vencimiento'], $data['contenido'], $data['peso_unitario'], $data['stock'], $data['reservado']); // creamos el nuevo objeto que se introducira en la BD
                    DetalleRepository::getInstance()->add($detalle_entidad); // aca esta el prob
                    $_SESSION["message"] = new MessageService("createSuccess", ["detalle de alimento"]);
                }
                $this->redirect();
            }
        }
    }

    public function edit($post) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $data = $post->getParams(); // obtenemos Los parametros
                /* TODO: el modulo  se puede refactorizar, es igual al create */
                if ($data['flag'] == 1) {
                    $query_alimento = AlimentoRepository::getInstance()->getByID($data['codigo-nuevo']);  
                    if (!$query_alimento) {
// Si no hay alimento con el mismo codigo...
                        $alimento = new AlimentoModel($data['codigo-nuevo'], $data['descripcion-nueva']);
                        AlimentoRepository::getInstance()->add($alimento); // es necesario que se haga en este instante para que funcione el
// constructor de abajo
                        $detalle = new DetalleModel($data['id'], $alimento->getCodigo(), $data['fecha_vencimiento'], $data['contenido'], $data['peso_unitario'], $data['stock'], $data['reservado']);
                        DetalleRepository::getInstance()->edit($detalle);
                        $_SESSION["message"] = new MessageService("modificationSuccess", ["detalle de alimento de tipo " . $data['codigo-nuevo']]);
                    }
                    else {
                        $_SESSION["message"] = new MessageService("modificationErrorExist", ["detalle", "tipo (" . $data['codigo-nuevo'] . ")"]);
                        }
                }
                else {
                    $detalle = new DetalleModel($data['id'], $data['alimento_codigo'], $data['fecha_vencimiento'], $data['contenido'], $data['peso_unitario'], $data['stock'], $data['reservado']); // creamos el nuevo objeto que se introducira en la BD
                    DetalleRepository::getInstance()->edit($detalle); 
                    
                    $_SESSION["message"] = new MessageService("modificationSuccess", ["detalle de alimento de tipo " . $data['alimento_codigo']]);
                }                    
                $this->redirect();
            }
        }
    }

    public function remove($id) {
        /* onupdate y onremove estan en Restrict o en cascade? 
          Preguntar que hacer!
         */
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                if (DetalleRepository::getInstance()->getByID($id)) {
                    DetalleRepository::getInstance()->remove($id);
                    //LoginController::getInstance()-> backend(); /* mensaje de todo ok */
                    $_SESSION["message"] = new MessageService("removeSucess", ["detalle"]);
                    header("Location: ../../alimentos");
                }
                else {
                    $_SESSION["message"] = new MessageService("modificationErrorNotExist", ["detalle"]);
                }
                $this->redirect();
            }
        }
    }

    public function index() {

        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
// Se traen todos los alimentos (tipos) y todos los detalles
// los alimentos se traen para poder completar la lista de tipos
                $Alimento = AlimentoRepository::getInstance()->getAll();
                $Detalle = DetalleRepository::getInstance()->getAll();
                $view = new BackEndView();
                $view->alimentos($Alimento, $Detalle);
            }
        }
    }

    public function editView($id) {
// ACA QUE TENGO QUE HACER?
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                if (DetalleRepository::getInstance()->getByID($id)) {
                    $Detalle = DetalleRepository::getInstance()->getByID($id);
                    $Alimento = AlimentoRepository::getInstance()->getAll();
                    $view = new BackEndView();
                    $view->editViewAlimento($Alimento, $Detalle); // si no devuelve nada esta vista se encarga
                }
                else {
                    // ERROR, no se encuentra el $DETALLE
                    $_SESSION["message"] = new MessageService("modificationErrorNotExist", ["detalle"]);
                }
            }
        }
    }

    public function listarAlimentos() {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $Detalle = DetalleRepository::getInstance()->getAll();
                $view = new BackEndView();
                $view->listado_alimentos($Detalle);
            }
        }
    }

}

<?php

/**
 * Description of TurnoController
 *
 * @author loscalzo
 */
class TurnoController extends Controller {

    //put your code here

    private static $instance = null;

    protected function redirect() {
        parent::redirect("turnosEntrega");
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
                $turnoAgregadoHora = $data['hora'];
                $data['fecha'] = DateTime::createFromFormat("d/m/Y", $data['fecha']);
                $data['fecha']= $data['fecha']->format('Y-m-d');
                $turnoAgregadoFecha = $data['fecha'];
                $entidadActual = TurnoRepository::getInstance()->getByFechaHora($turnoAgregadoFecha, $turnoAgregadoFecha);
                if (!$entidadActual) {
                    $entidad = new TurnoModel(
                            null, $data["fecha"], $data["hora"]);
                    TurnoRepository::getInstance()->add($entidad);
                    $_SESSION["message"] = new MessageService("createSuccess", [" Turno con fecha" . $turnoAgregadoFecha . " " . $turnoAgregadoHora]);
                } else {
                    // YA EXISTE LA ENTIDAD
                    $_SESSION["message"] = new MessageService("createErrorExist", [" Turno con fecha" . $turnoAgregadoFecha . " " . $turnoAgregadoHora]);
                }
                $this->redirect();
            }
        }
    }

    public function edit($post) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $data = $post->getParams(); // obtenemos Los parametros
                $entidadModificadaID = $data['id'];
                $data['fecha'] = DateTime::createFromFormat("d/m/Y", $data['fecha']);
                $data['fecha'] = $data['fecha']->format('Y-m-d');
                $turnoAgregadoFecha = $data['fecha'];
                $turnoAgregadoHora = $data['hora'];
                $entidadActual = TurnoRepository::getInstance()->getByFechaHora($turnoAgregadoFecha, $turnoAgregadoHora);
                // deberia validarse que la fecha es mayor a la actual.
                // CODE REFACTORIZADO, se puede transladar a otros casos.
                if ((!$entidadActual) || ($entidadActual->getId() === $entidadModificadaID)) {
                    $entidad = new TurnoModel(
                            $entidadModificadaID, $turnoAgregadoFecha,$turnoAgregadoHora);
                    TurnoRepository::getInstance()->edit($entidad);
                    $_SESSION["message"] = new MessageService("modificationSuccess", [" Turno con fecha" . $turnoAgregadoFecha . " " . $turnoAgregadoHora]);
                } else {
                    $_SESSION["message"] = new MessageService("modificationErrorExist", [" Turno", " Fecha (" . $turnoAgregadoFecha . " " . $turnoAgregadoHora . ")"]);
                }
            }
            $this->redirect();
        }
    }

    public function editView($id) {

        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $turnoInfo = TurnoRepository::getInstance()->getByID($id);
                if ($turnoInfo) {
                    $view = new BackEndView();
                    $view->editViewTurno($turnoInfo); // si no devuelve nada esta vista se encarga
                } else {
                    $_SESSION["message"] = new MessageService("modificationErrorNotExist", [" Turno de entrega"]);
                    $this->redirect();
                }
                
            }
        }
    }

    public function remove($id) {
        /* onupdate y onremove estan en Restrict o en cascade? 
          Preguntar que hacer!
         */
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $entidadInfo = TurnoRepository::getInstance()->getByID($id);
                if ($entidadInfo) {
                    TurnoRepository::getInstance()->remove($id);
                    $_SESSION["message"] = new MessageService("removeSucess", [" Turno de entrega"]);
                } else {
                    $_SESSION["message"] = new MessageService("removeErrorNotExist", [" Turno de entrega"]);
                }
                $this->redirect();
            }
        }
    }

    public function index() {
        /* comproba si hay una sesion valida
          ese metodo deberia enviarte al inicio directamente.
         */

        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $turnos = TurnoRepository::getInstance()->getAll();
                $view = new BackEndView();
                $view->Turnos($turnos);
            }
        }
    }

}

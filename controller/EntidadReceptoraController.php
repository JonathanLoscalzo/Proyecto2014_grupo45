<?php

include_once("model/EntidadReceptoraRepository.php"); //altos problemas con esta
include_once("model/EntidadReceptoraModel.php");

/**
 * Description of EntidadReceptoraController
 *  HABRIA QUE TENER EN CUENTA QUE ENTIDAD TIENE VARIAS VARIABLES CONECTADAS
 *  COMO SE RELACIONARIAN?
 * @author jloscalzo
 */
class EntidadReceptoraController extends Controller {

    private static $instance = null;

    protected function redirect() {
        parent::redirect("entidadesReceptoras");
    }
    
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function create($post) {
        /* $EntidadReceptora sin id de EntidadReceptora */
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $data = $post->getParams(); // obtenemos Los parametros
                $entidadAgregadaID = $data['razonSocial'];
                $entidadActual = EntidadReceptoraRepository::getInstance()->getByRazonSocial($entidadAgregadaID);
                if (!$entidadActual) {
                    $entidad = new EntidadReceptoraModel(
                            null, $data["razonSocial"], $data["telefono"], $data["domicilio"], $data["estadoEntidadID"], $data["necesidadEntidadID"], $data["servicioEntidadID"]);
                    EntidadReceptoraRepository::getInstance()->add($entidad);
                    $_SESSION["message"] = new MessageService("createSuccess", ["entidad con razón social " . $data['razonSocial']]);
                }
                else {
                    // YA EXISTE LA ENTIDAD
                    $_SESSION["message"] = new MessageService("createErrorExist", ["entidad con razón social " . $data['razonSocial']]);
                }
                $this->redirect();
            }
        }
    }

    public function edit($post) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $data = $post->getParams(); // obtenemos Los parametros
                $entidadModificadaID = $data['razonSocial'];
                $entidadActual = EntidadReceptoraRepository::getInstance()->getByRazonSocial($entidadModificadaID);
                if ((!$entidadActual) || ($entidadActual->getId() === $donanteModificadoID)) {
                    $entidad = new EntidadReceptoraModel(
                            $data["id"], $data["razonSocial"], $data["telefono"], $data["domicilio"], $data["estadoEntidadID"], $data["necesidadEntidadID"], $data["servicioPrestadoID"]);
                
                    EntidadReceptoraRepository::getInstance()->edit($entidad);
                    $_SESSION["message"] = new MessageService("modificationSuccess", ["entidad con razón social " . $data['razonSocial']]);
                } else {
                    $_SESSION["message"] = new MessageService("modificationErrorExist", ["entidad", "razon social (" . $data['razonSocial'] . ")"]);
                }
                header("Location: ../../entidadesReceptoras");
            }
            $this->redirect();
        }
    }

    public function editView($id) {

        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $entidadInfo = EntidadReceptoraRepository::getInstance()->getByID($id);
                if ($entidadInfo) {
                    $Necesidades = NecesidadEntidadRepository::getInstance()->getAll();
                    $Servicios = ServicioEntidadRepository::getInstance()->getAll();
                    $Estados = EstadoEntidadRepository::getInstance()->getAll();
                    $view = new BackEndView();
                    $view->editViewEntidadReceptora($entidadInfo, $Estados, $Necesidades, $Servicios); // si no devuelve nada esta vista se encarga
                } else {
                    $_SESSION["message"] = new MessageService("modificationErrorNotExist", ["Entidad Receptora"]);
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
                $entidadInfo = EntidadReceptoraRepository::getInstance()->getByID($id);
                if ($entidadInfo) {
                    EntidadReceptoraRepository::getInstance()->remove($id);
                    $_SESSION["message"] = new MessageService("removeSucess", ["entidad receptora"]);
                } else {
                    $_SESSION["message"] = new MessageService("removeErrorNotExist", ["entidad receptora"]);
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
                $EntidadesReceptoras = EntidadReceptoraRepository::getInstance()->getAll();
                $Necesidades = NecesidadEntidadRepository::getInstance()->getAll();
                $Servicios = ServicioEntidadRepository::getInstance()->getAll();
                $Estados = EstadoEntidadRepository::getInstance()->getAll();
                $view = new BackEndView();
                $view->EntidadesReceptoras($EntidadesReceptoras, $Estados, $Necesidades, $Servicios);
            }
        }
    }

}
